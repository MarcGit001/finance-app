@extends('layouts.app')

@section('content')

<h2 class="mb-4">💳 Dettes / Factures</h2>


@if(session('error'))
    <div class="alert alert-danger shadow-sm">
        ⚠️ {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success shadow-sm">
        ✅ {{ session('success') }}
    </div>
@endif

<a href="{{ url('/dettes/create') }}" class="btn btn-primary mb-3">
    ➕ Ajouter
</a>


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Retard</th>
            <th>Date échéance</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
@foreach($dettes as $d)
<tr>
    <td>{{ $d->type }}</td>
    <td>{{ $d->nom }}</td>
    <td>{{ $d->montant }}</td>
    
    
    <td>
        @if($d->statut == 'payé')
            <span class="text-success">Payé</span>

        @elseif($d->statut == 'partiel')
            <span class="text-warning">Partiel</span>
            <br>
            <small class="text-danger">
                reste {{ $d->montant - $d->montant_paye }} FCFA
            </small>

        @elseif($d->date_echeance && $d->date_echeance < date('Y-m-d'))
            <span class="text-danger">En retard</span>

        @else
            <span class="text-primary">En cours</span>
        @endif
    </td>

    <td>
        @if($d->date_echeance && $d->date_echeance < date('Y-m-d') && $d->statut != 'payé')
            <span class="badge bg-danger">En retard</span>
        @else
            <span class="badge bg-secondary">OK</span>
        @endif
    </td>

    <td>{{ $d->date_echeance }}</td>

    <td>
    <form action="{{ url('dettes/paiement/'.$d->id) }}" method="POST">
         @csrf
        <input type="number" name="montant" placeholder="Montant" required>
        <button class="btn btn-success btn-sm">Payer</button>
    </form>
</td>
</tr>
@endforeach

    </tbody>
</table>

<div class="mt-3 p-3 bg-light shadow">

    <p><strong>💳 Total dettes restantes :</strong> {{ $totalDettesRestantes }} FCFA</p>

    <p><strong>🧾 Total factures restantes :</strong> {{ $totalFactures }} FCFA</p>

</div>

@endsection