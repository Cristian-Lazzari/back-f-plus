@extends('layouts.baseClient')

@section('contents')
@php
$week = [
    'lunedì', 'martedì', 'mercoldì', 'giovedì', 'venerdì', 'sabato', 'domenica'
];
$pack =  [
    'Essntials | Y', 
    'Work on   | Y',
    'Boost up  | Y',
    'Essntials | M',
    'Work on   | M',
    'Boost up  | M',
];
$services_type = [
    'Asporto e/o domicilio' => 1,
    'prenotazione tavoli' => 2,
    'Asporto e/o domicilio e prenotazione tavoli' => 3,
];
$type_rs = [
    "ristorante","trattoria","pizzeria","sushi","steakhouse",
    "osteria","fast food","braceria","vegan","vegetariano","gourmet","fusion",
    "hamburgeria","pescheria","bistrot","tavola calda","wine bar","pasticceria",
    "gelateria","chiosco","taverna","buffet","self-service","pub", "cucina etnica"];
@endphp
@if (session('info'))
    @php
        $m = session('info')
    @endphp
    <div class="alert notify_success alert-dismissible fade show" role="alert">
        {{$m}}
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    @php
        $m = session('error')
    @endphp
    <div class="alert notify_success alert-dismissible fade show error" role="alert">
        {{$m}}
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('success'))
    @php
        $step = session('success')
    @endphp
    @if($step['step'] !== 4)
    <div class="alert notify_success alert-dismissible fade show" role="alert">
        {{$step['m']}}
        <button type="button" class="my_btn_3 mx-auto mt-4" data-bs-dismiss="alert" aria-label="Close">Continua la registrazione</button>
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif($step['step'] == 5)
    <div class="alert notify_success alert-dismissible fade show" role="alert">
        {{$step['m']}}
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

@endif
@if(isset($step) && $step['step'] == 5)
<div class="alert notify_success alert-dismissible fade show" role="alert">
    Complimenti <strong>{{Auth::user()->name}}</strong> hai completato la registrazione
    <button type="button" class="my_btn_3 mx-auto mt-4" data-bs-dismiss="alert" aria-label="Close">Vai alla Dashboard</button>
    <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif



<div class="page_nav">

    <h1>Benvenuto {{Auth::user()->name}}</h1>
    
    <div class="client-db ">
        
        <div class="left">
            <h2 class="title_lg">I dati delle tue attività</h2>
            @foreach ($consumer as $c)
            @php 
                if (isset($c->r_property)) {
                    $r_property = json_decode($c->r_property, 1);
                    $r_type = $r_property['r_type'] ;
                    $day_service = $r_property['day_service'];
                }else{
                    $r_property =[
                        'renewal_date' =>null
                ];
                    $r_type = '';
                    $day_service = null;
                }
                if (isset($c->domain)) {
                    $domain = json_decode($c->domain, 1) ;
                }else{
                    $domain = ['domain'=>'', 'type_domain'=> ''];
                }
                if (isset($c->menu)) {
                    $menu = json_decode($c->menu, 1) ;
                }else{
                    $menu = [];
                }
            @endphp
            <div class="anagraphic">
                <div class="top">
                    <h2>{{$c->activity_name}}</h2>
                </div>
                <p class="opacity-50 h3s">Dati del Proprietario</p>
                <form class="form-reg form-home" action="{{ route('client.complete_registration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <div class="split">
                        <div class="input_form">
                            <label for="type_agency" class="">Tipo di Azienda</label>

                            <div class="select">
                                <input
                                @if ($c->type_agency == 1) checked @endif
                                type="radio" class="btn-check" id="type_agency{{$c->activity_name}}" name="type_agency" value="1" >
                                <label class="my_btn-check" for="type_agency{{$c->activity_name}}">Libero professionista</label>
                                <input
                                @if ($c->type_agency == 2) checked @endif
                                type="radio" class="btn-check" id="type_agency{{$c->activity_name}}1" name="type_agency" value="2" >
                                <label class="my_btn-check" for="type_agency{{$c->activity_name}}1"> Ditta individuale</label>
                                <input
                                @if ($c->type_agency == 3) checked @endif
                                type="radio" class="btn-check" id="type_agency{{$c->activity_name}}2" name="type_agency" value="3" >
                                <label class="my_btn-check" for="type_agency{{$c->activity_name}}2">Azienda</label>
    
                            </div>
                            
                        </div>
                        <div class="input_form">
                            <label for="vat" class="">P. iva</label>
                            <input
                                type="text"
                                id="vat"
                                name="vat"
                                value="{{old('vat', $c->vat)}}"
                                required
                                placeholder="123456789012"
                                autocomplete="vat"
                                value="{{ old('vat') }}"
                            >
                        </div>
                        @error('type_agency') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('vat') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_form long">
                        <label for="address" class="">Sede legale dell'Attività</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            required
                            value="{{old('address', $c->address)}}"
                            placeholder="Via, numero civico, città, provincia"
                            autocomplete="address"
                            value="{{ old('address') }}"
                        >
                        @error('address') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="split">
                        <div class="input_form">
                            <div class="input_form">
                                <label for="owner_phone" class="">Telefono proprietario*</label>
                            <input
                                type="text"
                                id="owner_phone"
                                name="owner_phone"
                                required
                                value="{{old('owner_phone', $c->owner_phone)}}"
                                placeholder="+39 1234567890"
                                autocomplete="owner_phone"
                                value="{{ old('owner_phone', Auth::user()->phone) }}"
                            >
                            </div>
                        </div>
                        <div class="input_form">
                            <label for="pec" class="">Email (preferibilmente pec azienda)</label>
                            <input
                                type="text"
                                id="pec"
                                name="pec"
                                value="{{old('pec', $c->pec)}}"
                                required
                                placeholder="azienda@pec.it"
                                autocomplete="pec"
                                value="{{ old('pec') }}"
                            >
                        </div>
                        
                        @error('owner_phone') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('pec') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="split">
                        <div class="input_form">
                            <label for="owner_name" class="">Nome proprietario*</label>
                            <input
                                type="text"
                                id="owner_name"
                                name="owner_name"
                                value="{{old('owner_name', $c->owner_name)}}"
                                required
                                placeholder="Nome proprietario"
                                autocomplete="owner_name"
                            >
                            
                        </div>
                        <div class="input_form">
                            <label for="owner_surname" class="">Cognome proprietario*</label>
                            <input
                                type="text"
                                id="owner_surname"
                                name="owner_surname"
                                required
                                placeholder="Cognome proprietario"
                                autocomplete="owner_surname"
                                value="{{ old('owner_surname', $c->owner_surname) }}"
                            >
                        </div>
                        @error('owner_name') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('owner_surname') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_form long">
                        <label for="owner_cf" class="">Codice fiscale proprietario*</label>
                        <input
                            type="text"
                            id="owner_cf"
                            name="owner_cf"
                            required
                            placeholder="ACDSD1212D34DS"
                            autocomplete="owner_cf"
                            value="{{ old('owner_cf', $c->owner_cf) }}"
                        >
                        @error('owner_cf') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="my_btn_1 d-none">Modifica</button>
                </form>
                <p class="opacity-50 h3s">Dati dell'azienda</p>
                <form class="form-reg form-home" action="{{ route('client.complete_registration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="2">
                    <div class="split">
                        <div class="input_form">
                            <label for="r_type" class="">Tipo di locale</label>
                            <select name="r_type" id="">
                                
                                <option disabled selected class="disabled" value="">Segli il tipo di locale</option>
                                @foreach ($type_rs as $item)
                                <option 
                                @if (old('r_type', $r_type) == $item ) selected @endif
                                 value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input_form">
                            <label for="services_type" class="">Servizi del locale</label>
                            <select name="services_type" id="">
                                <option disabled selected class="disabled" value="{{$item}}">Seleziona i servizi del locale</option>
                                @foreach ($services_type as $key => $item)
                                <option
                                @if (old('services_type', $c->services_type ) == $item ) selected @endif
                                value="{{$item}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('r_type') <p class="error w-100">Seleziona un tipo di locale</p> @enderror
                        @error('services_type') <p class="error w-100">Seleziona i servizi che svolgi nel tuo locale</p> @enderror
                    </div> 
                    <div class="domain">
                        <h3>Hai già un altro sito web per questo locale?</h3>

                        <div class="checkbox-wrapper-35">
                            <input
                            @if ($domain['type_domain']) checked @endif
                             name="type_domain" id="switch" type="checkbox" class="switch">
                            <label for="switch">
                                <span class="switch-x-text">Attualmente </span>
                                <span class="switch-x-toggletext">
                                    <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked: </span>HO GIÀ</span>
                                    <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked: </span>NON HO</span>
                                </span>
                                <span class="switch-x-text">un sito web </span>
                            </label>
                        </div>
                        <div class="input_form">
                            <label for="domain" class="old">Inserisci il tuo sito web o il dominio che vorresti avere</label>
                            <input
                                type="text"
                                id="domain"
                                name="domain"
                                placeholder="Https:// dominio. it"
                                autocomplete="domain"
                                value="{{ old('domain', $domain['domain']) }}"
                            >
                        </div>
                        @error('domain') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="times">
                        <h3> Inserisci gli attuali orari di aperura</h3>
                        <div class="day-block-cont">
                            @foreach ($week as $day)
                            
                            <div class="day-block">
                                <input type="hidden" name="day_service[{{ $day }}]" value="{{ $day }}">
                                <label class="day" for="day{{$day}}">{{ $day }}</label>
                                @php 
                                if(old('day_service', $day_service) !== null) {
                                    $value =  old('day_service', $day_service)[$day] ;
                                } else {
                                    $value = '';
                                }
                                @endphp
                                
                                <div class="input-set">
                                    <input type="text" 
                                    value="{{$value}}"
                                    id="day{{$day}}" 
                                    name="day_service[{{ $day }}]" 
                                    placeholder="Es. 08:00 - 14:00 / 18:00 - 23:00">
                                    <label class="check-close-label
                                    @if ($value == 'Chiuso') dis  @endif
                                    " for="close{{$day . $c->id}}">Chiuso</label>
                                    <input
                                    @if ($value == 'Chiuso') checked @endif
                                    class="check-close" id="close{{$day . $c->id}}" type="checkbox" onchange="toggleTimeInput(this)">
                                </div>
                            </div>
                            @php $errorKey = 'day_service.' . $day; @endphp
    

                            @error($errorKey) <p class="error w-100">Selezionare un orario per {{ $day }}</p> @enderror
                            @endforeach
                        </div>
                    </div>
                    
                    @error('day_service') <p class="error w-100">{{ $message }}</p> @enderror
                    <div class="menu">
                        <h3>Il tuo menu</h3>
                        
                        <p class="w-100">
                            Hai caricato {{count($menu)}} file del tuo menu
                        </p>
                        <div class="container_file" > 
                            <div class="header_file dropzone"> 
                              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <p class="d-inline d-md-none" >Carica i tuoi file</p>
                                <p class="d-none d-md-inline" >Trascina i tuoi file</p>  
                            </div> 
                            <label for="fileInput2" class="footer_file"> 
                              <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path><path d="M18.153 6h-.009v5.342H23.5v-.002z"></path></g></svg> 
                              <p class="filename" >Nessun file selezionato</p> 
                              <div></div>
                            </label> 
                            <input class="fileInput-input" id="fileInput2" type="file" multiple name="menu[]"> 
                          </div>
                    </div>
                    @error('menu') <p class="error w-100">{{ $message }}</p> @enderror
                    @error('menu*') <p class="error w-100">{{ $message }}</p> @enderror
    
                    <button type="submit" class="my_btn_1 d-none">Conferma</button>
    
                </form>
                @if ($r_property['renewal_date'] && $c->status !== 0)    
                <p class="opacity-50 h3s">Gestisci il tuo abbonamento</p>
                    <div class="form-reg">
                        <p>Data di rinnovo: {{$r_property['renewal_date']}}</p>
                        <form class="w-100" action="{{ route('client.delete_sub') }}" method="POST">
                            <input type="hidden" name="id" value="{{$c->id}}">
                            @csrf
                            <button type="submit" class="ml-auto btn btn-danger">Annulla Abbonamento</button>
                        </form>
                        @php
                            $data_r = \Carbon\Carbon::parse($r_property['renewal_date']);
                            $today = \Carbon\Carbon::today();
                           // dump(!$data_r->lt($today)); //less then
                        @endphp
                        @if (!$data_r->lt($today))
                            <p>*Puoi annullare gratuitamente il tuo abbonamento entro il {{$r_property['renewal_date']}}</p>
                        @endif
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        <div class="right">
            <div class="service">
                <h2 class="title_lg">I tuoi servizi</h2>
                @foreach ($consumer as $c)
                @if ($c->domain !== null)
                    <div class="ticket">
                        @php
                            $domain = parse_url(json_decode($c->domain, 1)['domain'], PHP_URL_HOST)
                        @endphp
                        <img src="{{'https://' . $domain . '/img/favicon.png'}}" alt="">
                        <a href="{{'https://' . $domain}}">
                            <h1 >{{$c->activity_name}}</h1>
                        </a>
                        <div class="bottom">
                            @if ($c->active)

                                <a class="pack" href="https://future-plus.it/#pacchetti">Pacchetto: {{$pack[$c->status]}}</a>
                                <a class="pack" href="{{'https://db.'.$domain }}">Accedi alla Dashboard di {{$c->activity_name}}</a>

                            @elseif($c->status)
                                <p class="info">Servizio in fase in anlisi</p>
                            @else
                                <p class="warning">Completa la configurazione</p>
                            @endif
                        </div>
                       
                    </div>
                @else
                    <div class="ticket">
                        {{-- <img src="{{'https://' . $domain . '/img/favicon.png'}}" alt=""> --}}
                        <a href="/">
                            <h1 >{{$c->activity_name}}</h1>
                        </a>
                        <div class="bottom">
                            <p class="warning">Completa la configurazione</p>
                        </div>
                        <form action="{{ route('client.delete_sub', $c->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Annulla Abbonamento</button>
                        </form>
                    </div>
                @endif

                @endforeach
            </div>
            <div class="assistance">
                <h2 class="title_lg">La nostra assistenza</h2>
                <div class="ticket">
                    <img src="{{asset('public/favicon.png')}}" alt="">
                    <a href="https://future-plus.it">
                        <h1>Contattaci subito</h1>
                    </a>
                    <div class="bottom">
                        <a class="my_btn_1" href="https://calendly.com/futureplus-commerciale/scopri-come-restaurant-puo-svoltare-il-tuo-lavoro">Prenota una Call</a>
                        <a class="my_btn_7" href="tel:3271622244">Richiedi assistenza *</a>
                    </div>
                    <p>* L'assistenza telefonica è attiva dal lunedì al venerdì 10:00 - 19:00 </p>
                </div>
            </div>
        </div>
    </div>
</div>




{{-- //MODAL --}}
@if(isset($step) && $step['step'] == 1)
    <div class="alert notify_success alert-dismissible fade show" role="alert">
        Complimenti <strong>{{Auth::user()->name}}</strong> hai completato la prima parte della registrazione
        <button type="button" class="my_btn_3 mx-auto mt-4" data-bs-dismiss="alert" aria-label="Close">Continua la registrazione</button>
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="wrapper"  id="modal1" >

        <div class="registration-modal">
            <div class="top">
                <h1>Registrati gratuitamente su Future+</h1>
                <h2>Dati azienda</h2>
                <div class="crumbles">
                    <div class="circle active">1</div>
                    <div class="line"></div>
                    <div class="circle">2</div>
                    <div class="line"></div>
                    <div class="circle">3</div>
                    <div class="line"></div>
                    <div class="circle">4</div>
                </div>
            </div>
            <div class="body">
                <form class="form-reg" action="{{ route('client.complete_registration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <div class="split">
                        <div class="input_form">
                            <label for="type_agency" class="">Tipo di Azienda</label>
                            <div class="select">
                                <input type="radio" class="btn-check" id="type_agency" name="type_agency" value="1" >
                                <label class="my_btn-check" for="type_agency">Libero professionista</label>
                                <input type="radio" class="btn-check" id="type_agency1" name="type_agency" value="2" >
                                <label class="my_btn-check" for="type_agency1"> Ditta individuale</label>
                                <input type="radio" class="btn-check" id="type_agency2" name="type_agency" value="3" >
                                <label class="my_btn-check" for="type_agency2">Azienda</label>

                            </div>
                            
                        </div>
                        <div class="input_form">
                            <label for="vat" class="">P. iva</label>
                            <input
                                type="text"
                                id="vat"
                                name="vat"
                                required
                                placeholder="123456789012"
                                autocomplete="vat"
                                value="{{ old('vat') }}"
                            >
                        </div>
                        @error('type_agency') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('vat') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_form long">
                        <label for="address" class="">Sede legale dell'Attività</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            required
                            placeholder="Via, numero civico, città, provincia"
                            autocomplete="address"
                            value="{{ old('address') }}"
                        >
                        @error('address') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="split">
                        <div class="input_form">
                            <div class="input_form">
                                <label for="owner_phone" class="">Telefono proprietario*</label>
                            <input
                                type="text"
                                id="owner_phone"
                                name="owner_phone"
                                required
                                placeholder="+39 1234567890"
                                autocomplete="owner_phone"
                                value="{{ old('owner_phone', Auth::user()->phone) }}"
                            >
                            </div>
                        </div>
                        <div class="input_form">
                            <label for="pec" class="">Email (preferibilmente pec azienda)</label>
                            <input
                                type="text"
                                id="pec"
                                name="pec"
                                required
                                placeholder="azienda@pec.it"
                                autocomplete="pec"
                                value="{{ old('pec') }}"
                            >
                        </div>
                        
                        @error('owner_phone') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('pec') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="split">
                        <div class="input_form">
                            <label for="owner_name" class="">Nome proprietario*</label>
                            <input
                                type="text"
                                id="owner_name"
                                name="owner_name"
                                required
                                placeholder="Nome proprietario"
                                autocomplete="name"
                                value="{{ old('owner_name', Auth::user()->name )}}"
                            >
                            
                        </div>
                        <div class="input_form">
                            <label for="owner_surname" class="">Cognome proprietario*</label>
                            <input
                                type="text"
                                id="owner_surname"
                                name="owner_surname"
                                required
                                placeholder="Cognome proprietario"
                                autocomplete="last_surname"
                                value="{{ old('owner_surname', Auth::user()->surname) }}"
                            >
                        </div>
                        @error('owner_name') <p class="error w-100">{{ $message }}</p> @enderror
                        @error('owner_surname') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_form long">
                        <label for="owner_cf" class="">Codice fiscale proprietario*</label>
                        <input
                            type="text"
                            id="owner_cf"
                            name="owner_cf"
                            required
                            placeholder="ACDSD1212D34DS"
                            autocomplete="owner_cf"
                            value="{{ old('owner_cf') }}"
                        >
                        @error('owner_cf') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="my_btn_1">Conferma</button>
                </form>
            </div>
            <div class="foot">
                <div class="close_modal" id="close_modal1">Continua piu tardi la tua configuarazione</div>
                <div class="call">Prenota una Call con i nostri esperti</div>
            </div>
        </div>

    </div>
@elseif(isset($step) && $step['step'] == 2)
    <div class="wrapper" id="modal2">
        <div class="registration-modal">
            <div class="top">
                <h1>Registrati gratuitamente su Future+</h1>
                <h2>Dati Ristorante</h2>
                <div class="crumbles">
                    <div class="circle">1</div>
                    <div class="line"></div>
                    <div class="circle active">2</div>
                    <div class="line"></div>
                    <div class="circle">3</div>
                    <div class="line"></div>
                    <div class="circle">4</div>
                </div>
            </div>
            <div class="body">
                <form class="form-reg" action="{{ route('client.complete_registration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="2">
                    <div class="split">
                        <div class="input_form">
                            <label for="r_type" class="">Tipo di locale</label>
                            <select name="r_type" id="">
                                <option disabled selected class="disabled" value="">Segli il tipo di locale</option>
                                @foreach ($type_rs as $item)
                                <option 
                                @if (old('r_type') == $item ) selected @endif
                                value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input_form">
                            <label for="services_type" class="">Servizi del locale</label>
                            <select name="services_type" id="">
                                <option disabled selected class="disabled" value="{{$item}}">Seleziona i servizi del locale</option>
                                @foreach ($services_type as $key => $item)
                                <option
                                @if (old('services_type')== $item ) selected @endif
                                value="{{$item}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('r_type') <p class="error w-100">Seleziona un tipo di locale</p> @enderror
                        @error('services_type') <p class="error w-100">Seleziona i servizi che svolgi nel tuo locale</p> @enderror
                    </div> 
                    <div class="domain">
                        <h3>Hai già un altro sito web per questo locale?</h3>

                        <div class="checkbox-wrapper-35">
                            <input name="type_domain" id="switch{{$c->id}}" type="checkbox" class="switch">
                            <label for="switch{{$c->id}}">
                                <span class="switch-x-text">Attualmente </span>
                                <span class="switch-x-toggletext">
                                    <span class="switch-x-unchecked"><span class="switch-x-hiddenlabel">Unchecked: </span>HO GIÀ</span>
                                    <span class="switch-x-checked"><span class="switch-x-hiddenlabel">Checked: </span>NON HO</span>
                                </span>
                                <span class="switch-x-text">un sito web </span>
                            </label>
                        </div>
                        <div class="input_form">
                            <label for="domain" class="old">Inserisci il tuo sito web o il dominio che vorresti avere</label>
                            <input
                                type="text"
                                id="domain"
                                name="domain"
                                placeholder="Https:// dominio. it"
                                autocomplete="domain"
                                value="{{ old('domain') }}"
                            >
                        </div>
                        @error('domain') <p class="error w-100">{{ $message }}</p> @enderror
                    </div>
                    <div class="times">
                        <h3> Inserisci gli attuali orari di aperura</h3>
                        <div class="day-block-cont">
                            @foreach ($week as $day)
                            
                            <div class="day-block">
                                <input type="hidden" name="day_service[{{ $day }}]" value="{{ $day }}">
                                <label class="day" for="day{{$day}}">{{ $day }}</label>
                                @php 
                                if(old('day_service') !== null) {
                                    $value =  old('day_service')[$day] ;
                                } else {
                                    $value = '';
                                }
                                @endphp
                                
                                <div class="input-set">
                                    <input type="text" 
                                    value="{{$value}}"
                                    id="day{{$day}}" 
                                    name="day_service[{{ $day }}]" 
                                    placeholder="Es. 08:00 - 14:00 / 18:00 - 23:00">
                                    <label class="check-close-label
                                    @if ($value == 'Chiuso') dis  @endif
                                    " for="close{{$day}}">Chiuso</label>
                                    <input class="check-close" id="close{{$day}}" type="checkbox">
                                </div>
                            </div>
                            @php $errorKey = 'day_service.' . $day; @endphp

                            @error($errorKey) <p class="error w-100">Selezionare un orario per {{ $day }}</p> @enderror
                            @endforeach
                        </div>
                    </div>
                    
                    @error('day_service') <p class="error w-100">{{ $message }}</p> @enderror
                    <div class="menu">
                        <h3>Carica il tuo menu</h3>
                        <p>
                            Carica il tuo menu in formato PDF o immagine
                        </p>
                        <div class="container_file" > 
                            <div class="header_file dropzone"> 
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <p class="d-inline d-md-none" >Carica i tuoi file</p>
                                <p class="d-none d-md-inline" >Trascina i tuoi file</p>  
                            </div> 
                            <label for="fileInput" class="footer_file"> 
                            <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path><path d="M18.153 6h-.009v5.342H23.5v-.002z"></path></g></svg> 
                            <p class="filename" >Nessun file selezionato</p> 
                            <div></div>
                            </label> 
                            <input class="fileInput-input" id="fileInput" type="file" multiple name="menu[]"> 
                        </div>
                    </div>
                    @error('menu') <p class="error w-100">{{ $message }}</p> @enderror
                    @error('menu*') <p class="error w-100">{{ $message }}</p> @enderror

                    <button type="submit" class="my_btn_1">Continua la registrazione</button>

                </form>
                <div class="foot">
                    <div class="close_modal" id="close_modal2">Continua piu tardi la tua configuarazione</div>
                    <div class="call">Prenota una Call con i nostri esperti</div>
                </div>
            </div>
        </div>
    </div>
@elseif(isset($step) && $step['step'] == 3)
    @php
        $feature_pack = [
            'Essentals'=> [ 
                'feat' =>[
                    ['s'=> 1, 'f'=> 'Sito vetrina su dominio personalizzato'],
                    ['s'=> 1, 'f'=> 'Menu online con prezzi foto ed allergieni'],
                    ['s'=> 1, 'f'=> 'Dashboard con Software <span class="strg">Restaurant+ </span>'],
                    ['s'=> 0, 'f'=> 'Post per arricchire il tuo sito e mostrare i tuoi eventi '],
                    ['s'=> 0, 'f'=> 'Prenotazioni per cene e pranzi senza commisioni'],
                    ['s'=> 0, 'f'=> 'Ordini d’asporto senza commisioni'],
                    ['s'=> 0, 'f'=> 'Ordini a domicilio senza commisioni'],
                
                    ['s'=> 0, 'f'=> 'Notifiche tramite Email'],
                    ['s'=> 0, 'f'=> 'Gestione ordini / prenotazioni WhatsApp'],
                    ['s'=> 0, 'f'=> 'Email Marketing pronto all\'uso'],
                
                    ['s'=> 0, 'f'=> 'Pagamento online con fee Stripe (dal 1.5% al 2.5%)'],
                    ['s'=> 0, 'f'=> 'Statistiche e report su ordini e prenotazioni'],
                ],
                'price' =>[
                    'm' => '33',
                    'a' => '399'
                ]
            ],
            'Work On'=> [ 
                'feat' =>[
                    ['s'=> 1, 'f'=> 'Sito vetrina su dominio personalizzato'],
                    ['s'=> 1, 'f'=> 'Menu online con prezzi foto ed allergieni'],
                    ['s'=> 1, 'f'=> 'Dashboard con Software <span class="strg">Restaurant+ </span>'],
                    ['s'=> 1, 'f'=> 'Post per arricchire il tuo sito e mostrare i tuoi eventi '],
                    ['s'=> 1, 'f'=> 'Prenotazioni per cene e pranzi senza commisioni'],
                    ['s'=> 1, 'f'=> 'Ordini d’asporto senza commisioni'],
                    ['s'=> 1, 'f'=> 'Ordini a domicilio senza commisioni'],
                
                    ['s'=> 1, 'f'=> 'Notifiche tramite Email'],
                    ['s'=> 0, 'f'=> 'Gestione ordini / prenotazioni WhatsApp'],
                    ['s'=> 0, 'f'=> 'Email Marketing pronto all\'uso'],
                
                    ['s'=> 0, 'f'=> 'Pagamento online con fee Stripe (dal 1.5% al 2.5%)'],
                    ['s'=> 0, 'f'=> 'Statistiche e report su ordini e prenotazioni'],
                ],
                'price' =>[
                    'm' => '83',
                    'a' => '999'
                ]
            ],
            'Boost Up'=> [ 
                'feat' =>[
                    ['s'=> 1, 'f'=> 'Sito vetrina su dominio personalizzato'],
                    ['s'=> 1, 'f'=> 'Menu online con prezzi foto ed allergieni'],
                    ['s'=> 1, 'f'=> 'Dashboard con Software <span class="strg">Restaurant+ PRO</span>'],
                    ['s'=> 1, 'f'=> 'Post per arricchire il tuo sito e mostrare i tuoi eventi '],
                    ['s'=> 1, 'f'=> 'Prenotazioni per cene e pranzi senza commisioni'],
                    ['s'=> 1, 'f'=> 'Ordini d’asporto senza commisioni'],
                    ['s'=> 1, 'f'=> 'Ordini a domicilio senza commisioni'],
                
                    ['s'=> 1, 'f'=> 'Notifiche tramite Email'],
                    ['s'=> 1, 'f'=> 'Gestione ordini / prenotazioni WhatsApp'],
                    ['s'=> 1, 'f'=> 'Email Marketing pronto all\'uso'],
                
                    ['s'=> 1, 'f'=> 'Pagamento online con fee Stripe (dal 1.5% al 2.5%)'],
                    ['s'=> 1, 'f'=> 'Statistiche e report su ordini e prenotazioni'],
                ],
                'price' =>[
                    'm' => '99',
                    'a' => '1199'
                ]
            ],
        ];
        $counter = 1;

    @endphp
    <div class="wrapper" id="modal3">
        <div class="registration-modal pack_selction">
            <div class="top">
                <h1>Registrati gratuitamente su Future+</h1>
                <h2>Scegli il Pacchetto</h2>
                <div class="crumbles">
                    <div class="circle">1</div>
                    <div class="line"></div>
                    <div class="circle">2</div>
                    <div class="line"></div>
                    <div class="circle active">3</div>
                    <div class="line"></div>
                    <div class="circle">4</div>
                </div>
            </div>
            <div class="body">
                <div class="packages">
                    <div class="scelta">
                        <div id="scelta_b" class="left ball"></div>
                        <div id="scelta_m" class="off">Mensile</div>
                        <div id="scelta_a" class="aa on">Annuale</div>
                    </div>
                    <form class="prices" action="{{ route('client.complete_registration') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" value="3">
                        {{-- 1 annuale 2 mensile --}}
                        <input type="hidden" id="type_pay" name="type_pay" value="1"> 
                        @foreach ($feature_pack as $key => $value)
                            <div class="schedule">
        
                                <h4>{{$key}}</h4>
                                @foreach ($value['feat'] as $f)
                                    @if ($f['s'])
                                    <div class="feat">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                        </svg>
                                        <p>{!! $f['f'] !!}</p>
                                    </div>
                                    @else
                                    <div class="feat off">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                        <p>{!! $f['f'] !!}</p>
                                        
                                    </div>
                                    @endif
                                @endforeach
                                <div class="price-c">
                                    <p class="price">
                                        € <span class="unit_m">{{$value['price']['m']}}</span>,<span class="decimal_m">90</span>
                                        <span class="sp"> al mese </span>
                                    </p>
                                    <p class="price-y">
                                        € <span class="unit_a">{{$value['price']['a']}}</span>,<span class="decimal_a">90</span>
                                        <span class="sp">all'anno </span>
                                    </p>
                                    <span class="w-100 d-block">* iva inclusa.</span>
                                    <button value="{{$counter}}" name="pack" class="my_btn_3 w-100 mt-4">Seleziona "{{$key}}"</button>
                                </div>
                            </div>
                            @php
                                $counter ++;
                            @endphp
                        @endforeach
                    </form>
                </div>
            </div>
            <div class="foot">
                <div class="close_modal" id="close_modal3">Continua piu tardi la tua configuarazione</div>
                <div class="call">Prenota una Call con i nostri esperti</div>
            </div>
        </div>
    </div>
@elseif(isset($step) && $step['step'] == 4)
    <div class="wrapper" id="modal4">
        <div class="registration-modal">
            <div class="top">
                <h1>Registrati gratuitamente su Future+</h1>
                <h2>INSERISCI IL METODO DI PAGAMENTO</h2>
                <div class="crumbles">
                    <div class="circle">1</div>
                    <div class="line"></div>
                    <div class="circle">2</div>
                    <div class="line"></div>
                    <div class="circle">3</div>
                    <div class="line"></div>
                    <div class="circle active">4</div>
                </div>
            </div>
            <div class="body">
                
                <form id="payment-form" class="from-reg" >
                    @csrf
                    
                    <div class="full">
                        <label>Numero della carta</label>
                        <div id="card-number"></div>
                    </div>
                    <div class="split">
                        <div class="input_form">
                            <label>Data di Scadenza</label>
                            <div id="card-expiry"></div>
                        </div>
                        <div class="input_form">
                            <label>CVV</label>
                            <div id="card-cvc"></div>
                        </div>
                    </div>
                    <label for="terms"><input type="checkbox" name="terms" id="terms"> Dichiaro di aver letto ed accettato termini e condizioni</label>
                    <div id="card-errors"></div>
                    <button class="my_btn_1" id="submit">Avvia la prova gratuita</button>
                </form>
                
                
                
            </div>
            <div class="foot">
                <div class="close_modal" id="close_modal3">Continua piu tardi la tua configuarazione</div>
                <div class="call">Prenota una Call con i nostri esperti</div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
@endif
    
<script>
    document.addEventListener("DOMContentLoaded", function() {

        
        const modal = document.querySelectorAll('.wrapper');
        const close_modal = document.querySelectorAll('.close_modal');
        let i = 0
        
        //console.log(close_modal)
        if(close_modal){
            close_modal.forEach(element => {
                let m = modal[i]; 
                element.addEventListener('click', function() {
                    m.classList.add('d-none');
                });
                i ++ 
            });
        }

        let feature_pack = [
            { 
                mensile : {
                    unit : {
                        m: '49',
                        a: '598'
                    },
                    decimal : {
                        m: '90',
                        a: '72'
                    }
                },
                annuale : {
                    unit : {
                        m: '33',
                        a: '399'
                    },
                    decimal : {
                        m: '33',
                        a: '90'
                    }
                },
            },
            {
                mensile : {
                    unit : {
                        m: '99',
                        a: '1190'
                    },
                    decimal : {
                        m: '90',
                        a: '80'
                    }
                },
                annuale : {
                    unit : {
                        m: '83',
                        a: '999'
                    },
                    decimal : {
                        m: '32',
                        a: '90'
                    }
                },
            },
            { 
                mensile : {
                    unit : {
                        m: '129',
                        a: '1558'
                    },
                    decimal : {
                        m: '90',
                        a: '99'
                    }
                },
                annuale : {
                    unit : {
                        m: '99',
                        a: '1199'
                    },
                    decimal : {
                        m: '99',
                        a: '90'
                    }
                },
            },
        ]
        let decimal_m = document.querySelectorAll('.decimal_m');
        let decimal_a = document.querySelectorAll('.decimal_a');
        let unit_m = document.querySelectorAll('.unit_m');
        let unit_a = document.querySelectorAll('.unit_a');
        const input_scelta = document.querySelector('#type_pay');
        const scelta_b = document.querySelector('#scelta_b');
        const scelta_a = document.querySelector('#scelta_a');
        const scelta_m = document.querySelector('#scelta_m');
        if(scelta_m && scelta_a){
            scelta_m.addEventListener('click', function() {
                change_pay_type(1);
            });
            scelta_a.addEventListener('click', function() {
                change_pay_type(0);
            });     
        }
        function change_pay_type(m_a) {
            if (m_a) {
                input_scelta.value = 2
                let c = 0
                unit_m.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].mensile.unit.m
                    c++
                });
                c = 0
                decimal_m.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].mensile.decimal.m
                    c++
                });
                c = 0
                unit_a.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].mensile.unit.a
                    c++
                });
                c = 0
                decimal_a.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].mensile.decimal.a
                    c++
                });

                scelta_a.classList.add('off')
                scelta_a.classList.remove('on')
                scelta_a.classList.remove('aa')

                scelta_m.classList.add('on')
                scelta_m.classList.add('mm')
                scelta_m.classList.remove('off')
                
                scelta_b.classList.remove('left')
                scelta_b.classList.add('right')

            }else{
                input_scelta.value = 1
                let c = 0
                unit_m.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].annuale.unit.m
                    c++
                });
                c = 0
                decimal_m.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].annuale.decimal.m
                    c++
                });
                c = 0
                unit_a.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].annuale.unit.a
                    c++
                });
                c = 0
                decimal_a.forEach(e => {
                    e.innerHTML = ''
                    e.innerHTML = feature_pack[c].annuale.decimal.a
                    c++
                });
                
                scelta_a.classList.remove('off')
                scelta_a.classList.add('on')
                scelta_a.classList.add('aa')
                
                scelta_m.classList.remove('on')
                scelta_m.classList.remove('mm')
                scelta_m.classList.add('off')
                
                scelta_b.classList.add('left')
                scelta_b.classList.remove('right')
            }
        }      

        const forms = document.querySelectorAll('.form-home');   
        if(forms.length){
            forms.forEach(form => {
                const modifyButton = form.querySelector('button[type="submit"]');
                const initialFormState = new FormData(form);
                form.addEventListener('input', function() {
                    const currentFormState = new FormData(form);
    
                    let formChanged = false;
                    
                    for (let [key, value] of initialFormState.entries()) {
                        if (currentFormState.get(key) !== value) {
                            console.log(currentFormState.get(key));
                            console.log(value);
                            formChanged = true;
                            break;
                        }
                    }
                    console.log(formChanged);
    
                    if (formChanged) {
                        modifyButton.classList.remove('d-none');
                        console.log(modifyButton.classList);
                    }else {
                        modifyButton.classList.add('d-none');
                    }
                });
            });
        }

        let checkClose = document.querySelectorAll(".check-close")
        if(checkClose.length){
            checkClose.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    let input = this.closest('.input-set').querySelector('input[name*="day_service"]');
                    let label = this.closest('.day-block').querySelector('.check-close-label');
    
                    if (this.checked) {
                        input.value = 'Chiuso';
                        label.classList.add('dis');
                        input.readOnly = true;
                    } else {
                        label.classList.remove('dis');
                        input.readOnly = false;
                        input.value = '';
                    }
                });
            });
        }
 
        const fileInput = document.querySelectorAll(".fileInput-input");
        if (fileInput.length) {
            fileInput.forEach(fileInput => {
                let filename = fileInput.closest(".container_file").querySelector(".filename");
                let dropzone = fileInput.closest(".container_file").querySelector(".dropzone");
                dropzone.addEventListener("click", () => fileInput.click())
                fileInput.addEventListener("change", (event) => {
                    event.preventDefault();
                    const files = event.target.files;
                    updateFileList(files, filename);
                });
            
                dropzone.addEventListener("dragover", (event) => {
                    event.preventDefault();
                });
            
                dropzone.addEventListener("drop", (event) => {
                    event.preventDefault();
                    
                    const files = event.dataTransfer.files;
                    updateFileList(files, filename);
            
                    // Assegna i file droppati all'input file
                    const dataTransfer = new DataTransfer();
                    for (let i = 0; i < files.length; i++) {
                        dataTransfer.items.add(files[i]);
                    }
                    fileInput.files = dataTransfer.files; 
                });
            });
        }

        function updateFileList(files, filename) {
            filename.innerHTML = ""; 
            for (let i = 0; i < files.length; i++) {
                filename.innerHTML += ` ${files[i].name} `;
            }
        }

        const step = @json($step);
        
        if(step.step == 4){
            let stripe = Stripe("{{ config('c.STRIPE_KEY') }}");
    
            let elements = stripe.elements();
            let style = {
                base: {
                    fontSize: "18px",
                    fontFamily: "'Poppins', sans-serif",
                    color: "#333",
                    "::placeholder": {
                        color: "#09033399"
                    }
                },
                invalid: {
                    color: "#e3342f"
                }
            };
            
            // Creiamo gli input personalizzati
            let cardNumber = elements.create("cardNumber", { style });
            let cardExpiry = elements.create("cardExpiry", { style });
            let cardCvc = elements.create("cardCvc", { style });
    
            // Montiamo gli input nel form
            cardNumber.mount("#card-number");
            cardExpiry.mount("#card-expiry");
            cardCvc.mount("#card-cvc");
            const cardErrors = document.getElementById("card-errors")
            const btn_sumb_stripe = document.getElementById("payment-form")
            
            btn_sumb_stripe.addEventListener("submit", async function(event) {
                event.preventDefault();
                btn_sumb_stripe.classList.add('d-none')
                
                let terms = document.querySelector("#terms")
                if(!terms.checked){
                    cardErrors.innerText = 'Prima di proseguire è necessario leggere ed accettare Termini e Condizioni';
                    cardErrors.classList.add('error')
                    btn_sumb_stripe.classList.remove('d-none')
                    return
                }
                let {error, paymentMethod} = await stripe.createPaymentMethod({
                    type: "card",
                    card: cardNumber, // Usa il numero della carta separato

                });
    
                if (error) {
                    cardErrors.innerText = error.message;
                    cardErrors.classList.add('error')
                    btn_sumb_stripe.classList.remove('d-none')
                } else {
                    cardErrors.innerText = "";
                    cardErrors.classList.remove('error')
                    let response = await sendPaymentMethodToServer(paymentMethod.id);
                    
                }
                
                async function sendPaymentMethodToServer(paymentMethodId) {
                    let response = await fetch("/client/complete_registration", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethodId,
                            _token: "{{ csrf_token() }}", // Aggiunto direttamente nei dati
                            step: 4 // Aggiunto direttamente nei dati
                        })
                    });
    
                    let result = await response.json();
                    console.log(result)
                    if (result.success) {
                        const homeUrl = @json(route('client.dashboard')) + "?final=" + 5;
                        window.location.href = homeUrl;  
    
                    } else {
                        document.getElementById("card-errors").innerText = result.error;
                    }
                }
            });
        }

    });
</script>


<style>
    :root {
        --c1_op_3:#1e2d6430;
        --c1_op_5:#1e2d6486;
        --c1_op:#1e2d6472;
        --c2_op:#10b7937b;
        --c3_op:#d8dde880;
        --c1: #090333;
        --c2:#10b793;
        --c3: #d8dde8;
    }
    /* From Uiverse.io by Yaya12085 */ 
    .container_file {
        min-height: 400px;
        width: 300px;
        border-radius: 10px;
        box-shadow: 4px 4px 30px rgba(0, 0, 0, .2);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        gap: 5px;
        background: linear-gradient(145deg, var(--c1_op_3) , var(--c1_op_5));
    }

    .header_file {
        flex: 1;
        min-height: 300px;
        width: 100%;
        border: 2px dashed var(--c3);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        }

        .header_file svg {
        height: 100px;
        stroke: var(--c2);
        }
        .header_file svg path{
        stroke: var(--c3);
        }

        .header_file p {
        text-align: center;
        color: var(--c3);
        }

        .footer_file {
        background-color: var(--c3_op);
        width: 100%;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: var(--c1_op);
        border: none;
        }

        .footer_file svg {
        height: 40px;
        fill: var(--c3_op);
        background-color: var(--c1);
        border-radius: 10px;
        padding: 2px;
        cursor: pointer;
        box-shadow: 0 2px 30px rgba(0, 0, 0, 0.205);
        }

        .footer_file p {
        flex: 1;
        text-align: center;
        padding: 5px 0;
        margin: 0;
        }

        #fileInput, #fileInput2  {
        display: none;
        }


        /* From Uiverse.io by Bodyhc */ 
    .checkbox-wrapper-35 .switch {
    display: none;
    }
    .checkbox-wrapper-35{
        margin: 0 auto;
    }
    .checkbox-wrapper-35 .switch + label {
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    /* color: #78768d; */
    cursor: pointer;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;

    position: relative;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }

    .checkbox-wrapper-35 .switch + label::before,
    .checkbox-wrapper-35 .switch + label::after {
    content: '';
    display: block;
    margin-top: 1rem !important;
    margin-bottom: 1rem !important;
    }

    .checkbox-wrapper-35 .switch + label::before {
    background-color: #05012c;
    border-radius: 500px;
    height: 15px;
    margin: 0 3rem .5rem 1rem;
    -webkit-transition: background-color 0.125s ease-out;
    transition: background-color 0.125s ease-out;
    width: 25px;
    scale: 2;
    }

    .checkbox-wrapper-35 .switch + label::after {
    background-color: #fff;
    border-radius: 13px;
    box-shadow: 0 3px 1px 0 rgba(37, 34, 71, 0.05), 0 2px 2px 0 rgba(37, 34, 71, 0.1), 0 3px 3px 0 rgba(37, 34, 71, 0.05);
    height: 13px;
    /* margin: 0 2.5rem; */
    left: 8px;
    position: absolute;
    top: 1px;
    -webkit-transition: -webkit-transform 0.125s ease-out;
    transition: -webkit-transform 0.125s ease-out;
    transition: transform 0.125s ease-out;
    transition: transform 0.125s ease-out, -webkit-transform 0.125s ease-out;
    width: 13px;
    scale: 2;
    }

    .checkbox-wrapper-35 .switch + label .switch-x-text {
    display: block;
    margin-right: .3em;
    }

    .checkbox-wrapper-35 .switch + label .switch-x-toggletext {
    display: block;
    font-weight: bold;
    height: 2rem;
    overflow: hidden;
    position: relative;
    width: clamp(5rem, 8vw, 5.5rem);
    white-space: nowrap
    }

    .checkbox-wrapper-35 .switch + label .switch-x-unchecked,
    .checkbox-wrapper-35 .switch + label .switch-x-checked {
    left: 0;
    position: absolute;
    top: 0;
    -webkit-transition: opacity 0.125s ease-out, -webkit-transform 0.125s ease-out;
    transition: opacity 0.125s ease-out, -webkit-transform 0.125s ease-out;
    transition: transform 0.125s ease-out, opacity 0.125s ease-out;
    transition: transform 0.125s ease-out, opacity 0.125s ease-out, -webkit-transform 0.125s ease-out;
    }

    .checkbox-wrapper-35 .switch + label .switch-x-unchecked {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
    }

    .checkbox-wrapper-35 .switch + label .switch-x-checked {
    opacity: 0;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
    }

    .checkbox-wrapper-35 .switch + label .switch-x-hiddenlabel {
    position: absolute;
    visibility: hidden;
    }

    .checkbox-wrapper-35 .switch:checked + label::before {
    background-color: var(--c2);
    }

    .checkbox-wrapper-35 .switch:checked + label::after {
    -webkit-transform: translate3d(10px, 0, 0);
    transform: translate3d(10px, 0, 0);
    }

    .checkbox-wrapper-35 .switch:checked + label .switch-x-unchecked {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
    }

    .checkbox-wrapper-35 .switch:checked + label .switch-x-checked {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
    }

    @media (min-width: 550px) {

        .checkbox-wrapper-35 .switch + label::before,
        .checkbox-wrapper-35 .switch + label::after {
            margin-right: 70%;
        }
    }
</style>




@endsection
