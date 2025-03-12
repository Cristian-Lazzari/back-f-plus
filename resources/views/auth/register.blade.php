@extends('layouts.guestNoNav')

@section('contents')
<div class="register-page">
    <div class="hero">
        <div class="center_hero">
            <img src="{{ asset('logo.png') }}" alt="">
            <div class="right">
                <form method="POST" class="registration" action="{{ route('register') }}">
                    @csrf
                    <div class="split">
                        <div class="input_form">
                            
                            <label for="name" class="form-label">Nome</label>
                            <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            autofocus
                            autocomplete="name"
                            value="{{ old('name') }}"
                            >
                        </div>
                        <div class="input_form">
                            <label for="surname" class="form-label">Cognome</label>
                            <input
                            type="text"
                            id="surname"
                            name="surname"
                            required
                            autofocus
                            autocomplete="lastname"
                            value="{{ old('surname') }}"
                            >
                        </div>
                        @error('name') <p class="error">{{ $message }}</p> @enderror
                        @error('surname') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div class="split">
                        <div class="input_form">
                            
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="text"
                                id="email"
                                name="email"
                                required
                                autofocus
                                autocomplete="email"
                                value="{{ old('email') }}"
                            >
                        </div>
                        <div class="input_form">

                            <label for="phone" class="form-label">Telefono</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                required
                                autofocus
                                autocomplete="phone"
                                value="{{ old('phone') }}"
                            >
                        </div>
                           @error('email') <p class="error">{{ $message }}</p> @enderror
                           @error('phone') <p class="error">{{ $message }}</p> @enderror
                    </div>
                    <div class="full">
                        <label for="activity_name" class="form-label">Nome attività</label>
                        <input
                            type="text"
                            id="activity_name"
                            name="activity_name"
                            required
                            autofocus
                            autocomplete="activity_name"
                            value="{{ old('activity_name') }}"
                        >
                           @error('activity_name') <p class="error">{{ $message }}</p> @enderror
                    </div>
            
                    <div class="split">
                        <div class="input_form">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                        <div class="input_form">
                            <label for="password" class="form-label">Conferma Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                    </div>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                    <div class="act">

                        
                        <button type="submit" class="my_btn_5">Registrati</button>
                        <a class="my_link " href="{{ route('login') }}">
                            Ti sei già registrato?
                        </a>
                    </div>
                </form> 
            </div>
        </div>

    </div>

    
</div>




@endsection
