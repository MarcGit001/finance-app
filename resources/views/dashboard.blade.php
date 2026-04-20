@extends('layouts.app')

@section('content')

<h2 class="mb-3">📊 Tableau de bord</h2>

<!-- ALERTES DETTES -->
@foreach($dettes as $d)
    @if($d->statut != 'payé' && $d->date_echeance && now()->gt($d->date_echeance))
        <div class="alert alert-danger">
            ⚠️ Dette en retard : {{ $d->nom }} ({{ $d->montant }} FCFA)
        </div>
    @endif
@endforeach

<!-- ALERTES FINANCE -->
@if($solde < 0)
<div class="alert alert-danger">⚠️ Solde négatif !</div>
@endif

@if($totalDepenses > $totalRecettes)
<div class="alert alert-warning">⚠️ Dépenses supérieures aux revenus</div>
@endif

@if($solde > 0)
<div class="alert alert-success">✅ Situation financière stable</div>
@endif

<!-- CARTES -->
<div class="row mt-3 text-center">

    <div class="col-md-4">
        <div class="card bg-success text-white p-3 shadow">
            💰 Recettes <br><strong>{{ $totalRecettes }} FCFA</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white p-3 shadow">
            💸 Dépenses <br><strong>{{ $totalDepenses }} FCFA</strong>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white p-3 shadow">
            🧮 Solde <br><strong>{{ $solde }} FCFA</strong>
        </div>
    </div>

</div>

<!-- GRAPH -->
<div class="mt-4">
    <canvas id="financeChart"></canvas>
</div>

<!-- TRANSACTIONS -->
<h4 class="mt-4">🧾 3 dernières transactions</h4>

<div class="card shadow mt-4">
    <div class="card-header bg-dark text-white">
        🧾 Dernières transactions
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions->take(3) as $t)
                <tr>
                    <td>
                        <span class="badge {{ $t->type == 'recette' ? 'bg-success' : 'bg-danger' }}">
                            {{ $t->type }}
                        </span>
                    </td>

                    <td class="fw-bold">
                        {{ $t->montant }} FCFA
                    </td>

                    <td>{{ $t->description }}</td>

                    <td class="text-muted">
                        {{ $t->date }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Aucune transaction
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

<div class="card p-3 shadow mt-4">
    <h5>📅 Analyse du mois</h5>

    <p>📈 Meilleur jour : {{ $meilleurJour ?? 'N/A' }}</p>
    <p>💸 Plus grosse dépense : {{ $maxDepense ?? 0 }} FCFA</p>
    <p>💰 Plus gros revenu : {{ $maxRevenu ?? 0 }} FCFA</p>
</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
        labels: ['Recettes', 'Dépenses'],
        datasets: [{
            data: [{{ $totalRecettes }}, {{ $totalDepenses }}],
            backgroundColor: ['green', 'red']
        }]
    }
});
</script>

@endsection