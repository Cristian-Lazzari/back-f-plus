<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Customer;
use App\Models\Consumer;
use Stripe\Subscription;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home(Request $request) {
        $consumer = Consumer::where('user_id', Auth::user()->id)->get();
        $final = $request->query('final', 1);
        if($final == 5){
            $step = [ 'step' => 5, 'm' => 'Complimenti hai completato la registrazione a future+'];
            return view('client.dashboard', compact('step', 'consumer'));
        }
                
        $first = $consumer[0];
        $r_p_f = json_decode($first->r_property, 1);
        if($first->vat == null){ $s = 1;
        } elseif($first->domain == null){ $s = 2;    
        } elseif($first->status == 0){ $s = 3; 
        } elseif($r_p_f['stripe_id'] == ''){ $s = 3;//dd($r_p_f);
        } else { $s = 6; //complete
        }
        $step = [
            'step' => $s,
            'm' => null
        ];
       
        return view('client.dashboard', compact('step', 'consumer'));
    
    }
    public function delete_sub(Request $request) {

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $consumer = Consumer::where('id', $request['id'])->firstOrFail();
            $c = json_decode($consumer->r_property);

            if (!$c['stripe_id']) {
                return redirect()->back()->with('error', 'Utente non associato a Stripe.');
            }
            $subscription = Subscription::retrieve($c['subscription_id']);

            if ($subscription->status !== 'canceled') {
                $subscription->cancel();
                return redirect()->back()->with('success', 'Abbonamento annullato con successo.');
            }
            return redirect()->back()->with('info', 'L\'abbonamento è già stato annullato.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Errore: ' . $e->getMessage());
        }
    }

    public function complete_registration(Request $request) {
        $consumer = Consumer::where('user_id', Auth::user()->id)->get();
        $first = $consumer[0];
        $data = $request;
        $step = $data['step'];
        // dump($step);
        // dd($data);
        if($step == 1){ $step = $this->step_1($data, $first);
        } elseif($step == 2){ $step = $this->step_2($data, $first); 
        } elseif($step == 3){ $step = $this->step_3($data, $first);
        } elseif($step == 4){ $step = $this->step_4($data, $first);
            if($step['error'] == 'none'){
                return response()->json([
                    'success' => true, 
                ]);
            }else{
                return response()->json([
                    'success' => false, 
                    'error' => $step['error']
                ]);
            }
        } 
        return back()->with('success', $step);
    }

    protected function step_1($data, $consumer){
        $data->validate([
            'type_agency' => ['required'],
            'vat' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string', 'max:255'],
            'pec' => ['required', 'string', 'email', 'max:205'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_phone' => ['required', 'string', 'max:255'],
            'owner_surname' => ['required', 'string', 'max:255'],
            'owner_cf' => ['required', 'string', 'max:20'],
        ]);
        
        $consumer->owner_name = $data->owner_name;
        $consumer->owner_phone = $data->owner_phone;
        $consumer->owner_surname = $data->owner_surname;
        $consumer->owner_cf = $data->owner_cf;
        $consumer->type_agency = $data->type_agency;
        $consumer->address = $data->address;
        $consumer->vat = $data->vat;
        $consumer->pec = $data->pec;

        $info = $this->parseCodiceFiscale($data->owner_cf);

        $consumer->owner_bd = $info['data_nascita'] ?? null;
        $consumer->owner_sex = $info['genere'] ?? null;
        $consumer->owner_cm = '??'; //da implementare

        $consumer->update();
        $step = [
            'step'=> 2,
            'm'=> 'Complimenti hai completato con successo la seconda parte della registrazione'
        ];
        return $step;

        
    } 
    
    protected function step_2($data, $consumer){
        //dd($data['menu']);
        $data->validate([
            'menu' => ['nullable', 'array'], // Deve essere un array di file
            'menu.*' => ['file', 'mimes:jpeg,jpg,docx,xlsx', 'max:5120'], // Ogni file deve essere un'immagine max 2MB
            'r_type' => ['required'],
            'services_type' => ['required'],
            'day_service' => ['required','array'],
            'day_service.*' => ['required','string'],
            'domain' => ['required','url',],
        ]);

        $paths = [];

        if ($data->hasFile('menu')) {
            $files = is_array($data->file('menu')) ? $data->file('menu') : [$data->file('menu')];
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('menus', 'public'); 
                    $paths[] = $path;
                }
            }
        }
        
        $day_service = [];
        $r_property = [
            'day_service' => $data['day_service'],
            'r_type' => $data['r_type'],
            'activation_date' => '',
            'renewal_date' => '',
            'stripe_id' => '',
            'subscription_id' => ''
        ];
        
        $consumer->menu = json_encode(array_values($paths), JSON_UNESCAPED_SLASHES);
        $consumer->r_property = json_encode($r_property);
        $consumer->services_type = $data['services_type'];
        $domain = [
            'domain'=>$data['domain'],
            'type_domain'=>$data['type_domain']
        ];
        $consumer->domain = json_encode($domain);
        $consumer->update();

        $step = [
            'step'=> 3,
            'm'=> 'Complimenti hai completato con successo la terza parte della registrazione'
        ];
        return $step; 
    }

    protected function step_3($data, $consumer){

        // impostare pacchetto e tipo fatturazione (mensile / annuale)
        // $status = [     'niente ancora',     'Essntials | Y',      'Work on   | Y',     'Boost up  | Y',     'Essntials | M',     'Work on   | M',     'Boost up  | M',
        // ];
        $ty = $data['type_pay'];
        if($ty == 1){
            $consumer->status = $data['pack'];
        }else{
            $consumer->status = $data['pack'] + 3;
        }
        $consumer->update();
        $step = [
            'step'=> 4,
            'm'=> ''
        ];
        return $step;
    }
    protected function step_4($data, $consumer){
        try {
            Stripe::setApiKey(config('c.STRIPE_SECRET'));
    
            // Creazione del cliente su Stripe
            $customer = Customer::create([
                'email' => auth()->user()->email,
                'payment_method' => $data->payment_method, // Associa metodo di pagamento
                'invoice_settings' => ['default_payment_method' => $data->payment_method] // Assicura che venga usato per i pagamenti automatici
            ]);
            $price_list= [
                '',
                'price_1OlsotCusoKCSgsdwj59SwgF',
                'price_1QMbNVCusoKCSgsdpIav4RY4',
                'price_1QMdb1CusoKCSgsdYXeDCz9r',
                
                'price_1QMbKICusoKCSgsdgIZXpYq1',
                'price_1QMdY0CusoKCSgsdbeXqOjtW',
                'price_1QMde1CusoKCSgsdpY5oJfEm',
            ];
            // Creazione dell'abbonamento con pagamento automatico
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [['price' => 'price_1OlsrICusoKCSgsdH4AUgm4Q']], // Usa il tuo price_id reale
                //'items' => [['price' => $price_list[$consumer->status]]], // Usa il tuo price_id reale
                'off_session' => true, // Nessuna conferma manuale
                'automatic_tax' => ['enabled' => false],
                //'trial_period_days' => 30, // Imposta il numero di giorni di prova gratuita
            ]);
            //dd($subscription);
            
            // Salvataggio dei dati nel DB dell'utente
            $r_p = json_decode($consumer->r_property, 1) ;
            $r_p['activation_date'] = Carbon::now()->format('Y-m-d');
            $r_p['renewal_date']    = Carbon::now()->addDays(30)->format('Y-m-d');
            $r_p['stripe_id']       = $customer->id;
            $r_p['subscription_id'] = $subscription->id;

            $consumer->r_property = json_decode($consumer->r_property, 1);
            $consumer->update();
            $step = [
                'error'=> 'none',
                'step'=> 5,
                'm'=> 'Complimenti hai completato con successo la registrazione'
            ];
            return $step;
        } catch (\Exception $e) {
            $step = [
                'error'=> $e->getMessage(),
                'step'=> 5,
                'm'=> 'Complimenti hai completato con successo la registrazione'
            ];
            return $step;
        }
        // impostare pacchetto e tipo fatturazione (mensile / annuale)


        
    }

    protected function parseCodiceFiscale($cf) {
        if (strlen($cf) !== 16) {
            return null; // Codice fiscale non valido
        }
        // Estrarre anno, mese, giorno e codice comune
        $anno = substr($cf, 6, 2);
        $mese = substr($cf, 8, 1);
        $giorno = intval(substr($cf, 9, 2));
        $codice_comune = substr($cf, 11, 4);
        // Tabella conversione per il mese
        $mesi = [
            'A' => '01', 'B' => '02', 'C' => '03', 'D' => '04', 'E' => '05', 'H' => '06',
            'L' => '07', 'M' => '08', 'P' => '09', 'R' => '10', 'S' => '11', 'T' => '12'
        ];
        // Controllare il mese valido
        if (!isset($mesi[$mese])) {
            return null; // Mese non valido
        }
        // Determinare il genere
        $genere = ($giorno > 31) ? 'F' : 'M';
        if ($giorno > 31) {
            $giorno -= 40;
        }
        // Determinare l'anno completo (assumiamo che il CF sia valido dal 1900 in poi)
        $anno = ($anno > date('y')) ? "19$anno" : "20$anno";
        $info = [
            'data_nascita' => "$anno-$mesi[$mese]-" . str_pad($giorno, 2, '0', STR_PAD_LEFT),
            'genere' => $genere,
            'comune' => $codice_comune
        ];

        return $info;
    }
}
