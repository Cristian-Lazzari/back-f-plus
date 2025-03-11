<?php

namespace App\Http\Controllers\Client;

use App\Models\Consumer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home() {
        $consumer = Consumer::where('user_id', Auth::user()->id)->get();        
        if(count($consumer) === 0){
            Auth::logout();
            return view('auth.register');
        } else {
            $first = $consumer[0];
            if($first->vat == null){
                $s = 1;
            } elseif($first->domain == null){
                $s = 2;    
            } elseif($first->r_style == null){ 
                $s = 3;
            } else {
                $s = 4;
            }
            $step = [
                'step' => $s,
                'm' => null
            ];
            
            return view('client.dashboard', compact('step', 'consumer'));
        }
    }

    public function complete_registration(Request $request) {
        $consumer = Consumer::where('user_id', Auth::user()->id)->get();
        $first = $consumer[0];
        $data = $request;
        $step = $data->step;
        if($step == 1){
            $this->step_1($data, $first);
        } elseif($step == 2){
            $this->step_2($data, $first); 
        } elseif($step == 3){
            $this->step_3($data, $first);
        }
    }

    protected function step_1($data, $consumer){
        $data->validate([
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_surname' => ['required', 'string', 'max:255'],
            'owner_cf' => ['required', 'string', 'max:20'],
            'type_agency' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'vat' => ['required', 'string', 'max:25'],
            'pec' => ['required', 'string', 'email', 'max:205'],
        ]);
        $consumer->owner_name = $data->owner_name;
        $consumer->owner_surname = $data->owner_surname;
        $consumer->owner_cf = $data->owner_cf;
        $consumer->type_agency = $data->type_agency;
        $consumer->address = $data->address;
        $consumer->vat = $data->vat;
        $consumer->pec = $data->pec;

        $info = $this->parseCodiceFiscale($data->owner_cf);

        $consumer->owner_bd = $info['data_nascita'];
        $consumer->owner_sex = $info['genere'];
        $consumer->owner_cm = $info['comune'];

        $consumer->update();
        $step = [
            'step'=> 2,
            'm'=> 'Complimenti hai completato con successo la prima parte della registrazione'
        ];

        return back()->with('success', $step);
    } 
    
    protected function step_2($data, $consumer){
        $data->validate([
            'menu' => ['required', 'array'], // Deve essere un array di file
            'menu.*' => ['image', 'max:2048'], // Ogni file deve essere un'immagine max 2MB

            'r_type' => ['required'],
            'services_type' => ['required'],
            'day_service' => ['required','array'],
            'day_service.*.time' => ['nullable','string'],
            'domain' => ['required','nullable','url',],
            'type_domain' => ['required'],
        ]);

        $paths = [];

        if ($data->hasFile('menu')) {
            foreach ($data->file('menu') as $image) {
                $path = $image->store('menus', 'public'); // Salva in storage/app/public/menus
                $paths[] = $path;
            }
        }
        $consumer->menu = json_encode($paths); // Salva i percorsi come JSON
    
        $day_service = [];
    
        foreach ($data['day_service'] as $day => $d) {
            $day_service[$day] = $d['time'] ?? null;
        }
        $r_property = [
            'day_service' => $day_service,
            'r_type' => $data->r_type,
        ];

        $consumer->r_property = json_encode($r_property);
        $consumer->services_type = $data->services_type;
        $domain = [
            'domain'=>$data->domain,
            'type_domain'=>$data->type_domain
        ];
        $consumer->domain = json_encode($domain);
        $consumer->update();

        $step = [
            'step'=> 3,
            'm'=> 'Complimenti hai completato con successo la seconda parte della registrazione'
        ];
        return back()->with('success', $step); 
    }

    protected function step_3($data, $consumer){
        // Implementazione della terza fase
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
