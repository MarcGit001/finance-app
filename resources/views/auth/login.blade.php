@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card p-4 shadow" style="width: 400px;">

        <h3 class="text-center mb-3">🔐 Connexion</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Mot de passe" required>

            <button class="btn btn-dark w-100">Se connecter</button>
        </form>

        <p class="text-center mt-3">
            Pas de compte ?
            <a href="{{ route('register') }}">Créer</a>
        </p>

    </div>
</div>

@endsection