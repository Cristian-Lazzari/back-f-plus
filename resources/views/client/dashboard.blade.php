@extends('layouts.baseClient')

@section('contents')

<h1>Benvenuto {{Auth::user()->name}}</h1>

<div class="client-db db">
    <div class="left">
        <div class="angraphic">
            <form action="" class="consumer">
                
            </form>
        </div>
    </div>
</div>
    @php
        $week = [
            'lunedì', 'martedì', 'mercoldì', 'giovedì', 'venerdì', 'sabato', 'domenica'
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

@if (session('success'))
    @php
        $step = session('success')
    @endphp
    <div class="alert alert-success">
        {{ $step['m'] }}
    </div>
@endif
@php
    dd($step)['step'];
    dd($step['step'] == 1);
@endphp
@if($step['step'] == 1)

    <div id="modal1" class="mymodal">
        <div class="top">
            <h2>Dati azienda</h2>
            <div class="crumbles">
                <div class="cicle active">1</div>
                <div class="line"></div>
                <div class="cicle">2</div>
                <div class="line"></div>
                <div class="cicle">3</div>
            </div>
        </div>
        <div class="body">
            <form action="">
                <div class="split">
                    <div class="input_group">
                        <label for="type_agency" class="form-label">P. iva</label>
                        <div class="select">
                            <input
                                type="checkbox"
                                id="type_agency"
                                name="type_agency"
                                required
                                value="1"
                            >
                            <input
                                type="checkbox"
                                id="type_agency"
                                name="type_agency"
                                required
                                value="2"
                            >
                            <input
                                type="checkbox"
                                id="type_agency"
                                name="type_agency"
                                required
                                value="3"
                            >
                        </div>
                        @error('type_agency') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_group">
                        <label for="vat" class="form-label">P. iva</label>
                        <input
                            type="text"
                            id="vat"
                            name="vat"
                            required
                            autocomplete="vat"
                            value="{{ old('vat') }}"
                        >
                        @error('vat') <p class="error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="input_group long">
                    <label for="address" class="form-label">Sede legale dell'Attività</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        required
                        autocomplete="address"
                        value="{{ old('address') }}"
                    >
                    @error('address') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="input_group long">
                    <label for="pec" class="form-label">Pec</label>
                    <input
                        type="text"
                        id="pec"
                        name="pec"
                        required
                        autocomplete="pec"
                        value="{{ old('pec') }}"
                    >
                    @error('pec') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="split">
                    <div class="input_group">
                        <label for="owner_name" class="form-label">Nome proprietario*</label>
                        <input
                            type="text"
                            id="owner_name"
                            name="owner_name"
                            required
                            autocomplete="owner_name"
                            value="{{ old('owner_name')}}"
                        >
                        @error('owner_name') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_group">
                        <label for="owner_surname" class="form-label">Cognome proprietario*</label>
                        <input
                            type="text"
                            id="owner_surname"
                            name="owner_surname"
                            required
                            autocomplete="owner_surname"
                            value="{{ old('owner_surname') }}"
                        >
                        @error('owner_surname') <p class="error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="input_group long">
                    <label for="cf" class="form-label">Codice fiscale proprietario*</label>
                    <input
                        type="text"
                        id="cf"
                        name="cf"
                        required
                        autocomplete="cf"
                        value="{{ old('cf') }}"
                    >
                    @error('cf') <p class="error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="my_btn_2">Conferma</button>

            </form>
        </div>
        <div class="foot">
            <div class="close" id="close_modal1">Continua piu tardi la tua configuarazione</div>
            <div class="call">Prenota una Call con i nostri esperti</div>
        </div>
    </div>

@elseif($step['step'] === 2)
    <div id="modal2" class="mymodal">
        <div class="top">
            <h2>Dati Ristorante</h2>
            <div class="crumbles">
                <div class="cicle">1</div>
                <div class="line"></div>
                <div class="cicle active">2</div>
                <div class="line"></div>
                <div class="cicle">3</div>
            </div>
        </div>
        <div class="body">
            <form action="{{ route('consumer.upload') }}" method="POST" enctype="multipart/form-data">
                <div class="split">
                    <div class="input_group">
                        <label for="r_type" class="form-label">Tipo di locale</label>
                        <div class="select">
                            @foreach ($type_rs as $item)
                            <p class="not_active">
                                {{$item}}
                                <input
                                    type="checkbox"
                                    id="r_type"
                                    name="r_type"
                                    value="{{$item}}"
                                >
                            </p> 
                            @endforeach

                        </div>
                        @error('r_type') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div class="input_group">
                        <label for="services_type" class="form-label">Tipo di locale</label>
                        <div class="select">
                            @foreach ($services_type as $day)
                            
                            <div class="day-block">
                                <label>{{ $day }}</label>
                                <input type="hidden" name="hours[{{ $day }}][day]" value="{{ $day }}">
                    
                                <div class="split">
                                    <label>Orario:</label>
                                    <input type="text" name="hours[{{ $day }}][time]" placeholder="Es. 08:00 - 14:00 / 18:00 - 23:00">
                                </div>
                    
                                <label class="close_time">
                                    <input type="checkbox" name="hours[{{ $day }}][closed]" value="1">
                                    Chiuso
                                </label>
                            </div>
                            @endforeach


                        </div>
                        @error('services_type') <p class="error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="input_group long">
                    <h3>Hai gia un altro sito web per questo locale?</h3>
                    <div class="toggle-button-cover">
                        <div id="button-3" class="button r">
                            <input class="checkbox" name="type_domain" type="checkbox">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                    @error('domain') <p class="error">{{ $message }}</p> @enderror
                    <div class="dynamic_domain">
                        <label for="domain" class="l1">Inserisci il tuo sito web</label>
                        <label for="domain" class="l2">Quale dominio vorresti avere?</label>
                        <input
                            type="text"
                            id="domain"
                            name="domain"
                            placeholder="Https:// dominio. it"
                            autocomplete="domain"
                            value="{{ old('domain') }}"
                        >
                    </div>

                    @error('domain') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="input_group long">
                    <label for="pec" class="form-label">Inserisci gli attuali orari di aperura</label>
                    @foreach ($services_type as $key => $value)
                    <p class="not_active">
                        {{$key}}
                        <input
                            type="checkbox"
                            id="services_type"
                            name="services_type"
                            value="{{$value}}"
                        >
                    </p> 
                    @endforeach
                </div>
                <div class="menu">
                    <div class="container_file"> 
                        <div class="header_file"> 
                          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                            <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg> <p>Browse File to upload!</p>
                        </div> 
                        <label for="file" class="footer_file"> 
                          <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path><path d="M18.153 6h-.009v5.342H23.5v-.002z"></path></g></svg> 
                          <p>Nessun file selezionato</p> 
                          <div></div>
                        </label> 
                        <input id="file" type="file" multiple name="menu[]"> 
                      </div>
                </div>
                @error('menu') <p class="error">{{ $message }}</p> @enderror

                <button type="submit" class="my_btn_2">Conferma</button>

            </form>
        </div>
    </div>
@elseif($step['step'] === 4)
@endif
    
<script>

document.addEventListener("DOMContentLoaded", function() {
    const modal_1 = document.querySelector('#modal1')
    const modal_2 = document.querySelector('#modal2')
    const close_modal_1 = document.querySelector('#close_modal1')
    const close_modal_2 = document.querySelector('#close_modal2')

    close_modal_1.addEventListener('click', close_modal(modal_1))
    close_modal_2.addEventListener('click', close_modal(modal_2))
    function close_modal(modal){
        modal.classList.add('d-none');
    } 
    
    function toggleTimeInput(checkbox) {
        let input = checkbox.closest('.day-block').querySelector('input[name*="[time]"]');
        if (checkbox.checked) {
            input.value = 'Chiuso';
            input.readOnly = true;
        } else {
            input.value = '';
            input.readOnly = false;
        }
    }
})
</script>


<style>
    /* From Uiverse.io by Yaya12085 */ 
.container_file {
  height: 300px;
  width: 300px;
  border-radius: 10px;
  box-shadow: 4px 4px 30px rgba(0, 0, 0, .2);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  gap: 5px;
  background-color: rgba(0, 110, 255, 0.041);
}

.header_file {
  flex: 1;
  width: 100%;
  border: 2px dashed royalblue;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.header_file svg {
  height: 100px;
}

.header_file p {
  text-align: center;
  color: black;
}

.footer_file {
  background-color: rgba(0, 110, 255, 0.075);
  width: 100%;
  height: 40px;
  padding: 8px;
  border-radius: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  color: black;
  border: none;
}

.footer_file svg {
  height: 130%;
  fill: royalblue;
  background-color: rgba(70, 66, 66, 0.103);
  border-radius: 50%;
  padding: 2px;
  cursor: pointer;
  box-shadow: 0 2px 30px rgba(0, 0, 0, 0.205);
}

.footer_file p {
  flex: 1;
  text-align: center;
}

#file {
  display: none;
}
</style>




@endsection
