@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
    <div class="card p-4 shadow" style="width: 400px;">

        <h3 class="text-center mb-3">📝 Inscription</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" class="form-control mb-3" placeholder="Nom" required>

            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Mot de passe" required>

            <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirmer mot de passe" required>

            <button class="btn btn-dark w-100">S'inscrire</button>
        </form>

        <p class="text-center mt-3">
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </p>

    </div>
</div>

@endsection