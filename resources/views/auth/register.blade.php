@extends('layouts.guestNoNav')

@section('contents')

    <form method="post" class="registration" action="{{ route('register') }}">
        @csrf
        <div class="split">
            
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
               @error('name') <p class="error">{{ $message }}</p> @enderror
            <label for="surname" class="form-label">Cognome</label>
            <input
                type="text"
                id="surname"
                name="surname"
                required
                autofocus
                autocomplete="surname"
                value="{{ old('surname') }}"
            >
               @error('surname') <p class="error">{{ $message }}</p> @enderror
        </div>
        <div class="split">
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
               @error('email') <p class="error">{{ $message }}</p> @enderror

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

            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="new-password"
            >
        
            <label for="password" class="form-label">Conferma Password</label>
            <input
                type="password"
                id="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            >
        </div>
        @error('password') <p class="error">{{ $message }}</p> @enderror
        <a class="link" href="{{ route('login') }}">
            Ti sei già registrato?
        </a>

        <button type="submit" class="my_btn_2 my-5">Registrati</button>
    </form>

@endsection
