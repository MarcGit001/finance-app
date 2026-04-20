@extends('layouts.app')

@section('content')

<h2>➕ Ajouter une dette / facture</h2>

<form method="POST" action="{{ url('/dettes/store') }}">
    @csrf

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control">
    </div>

    <div class="mb-3">
        <label>Montant</label>
        <input type="number" name="montant" class="form-control">
    </div>

    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control">
            <option value="dette">Dette</option>
            <option value="facture">Facture</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Date échéance</label>
        <input type="date" name="date_echeance" class="form-control">
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <button class="btn btn-primary">Ajouter</button>

</form>

@endsection