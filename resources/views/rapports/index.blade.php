@extends('layouts.app')

@section('content')

<h2>📊 Rapports financiers</h2>


<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <input type="date" name="date" class="form-control">
    </div>

    <div class="col-md-4">
        <select name="mois" class="form-control">
            <option value="">-- Choisir mois --</option>
            @for($i=1; $i<=12; $i++)
                <option value="{{ $i }}">Mois {{ $i }}</option>
            @endfor
        </select>
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary w-100">Filtrer</button>
    </div>

</form>


<div class="row">

    <div class="col-md-6">
        <div class="card p-3 shadow-lg border-0">
            <h5>💰 Recettes</h5>
            <h3 class="text-success">{{ $recettes }} FCFA</h3>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow-lg border-0">
            <h5>💸 Dépenses</h5>
            <h3 class="text-danger">{{ $depenses }} FCFA</h3>
        </div>
    </div>

</div>


<div class="row mt-4">

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>🔥 Plus grosse dépense</h5>
            @if($topDepense)
                <p>{{ $topDepense->description }}</p>
                <strong class="text-danger">{{ $topDepense->montant }} FCFA</strong>
            @else
                <p>Aucune donnée</p>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>🔥 Plus grand revenu</h5>
            @if($topRevenu)
                <p>{{ $topRevenu->description }}</p>
                <strong class="text-success">{{ $topRevenu->montant }} FCFA</strong>
            @else
                <p>Aucune donnée</p>
            @endif
        </div>
    </div>

</div>


<div class="mt-4">

    <div class="card p-3 shadow-sm">
        <h5>🧠 Analyse automatique</h5>

        @foreach($analyse as $a)
            <div class="alert alert-warning">
                {{ $a }}
            </div>
        @endforeach

    </div>

</div>


<div class="row mt-4">

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>📅 Rapport journalier</h5>
            <p>Recettes : {{ $recettesJour }} FCFA</p>
            <p>Dépenses : {{ $depensesJour }} FCFA</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>📆 Rapport mensuel</h5>
            <p>Recettes : {{ $recettesMois }} FCFA</p>
            <p>Dépenses : {{ $depensesMois }} FCFA</p>
        </div>
    </div>

</div>

@endsection