@extends('layouts.app')

@section('content')

<h3>🚨 Alertes intelligentes</h3>
@if(count($alertes) == 0)
    <div class="alert alert-success">
        ✅ Aucune alerte pour le moment
    </div>
@endif

<h4 class="mt-4">📈 Analyse des flux financiers</h4>

<canvas id="alertChart"></canvas>

@foreach($alertes as $a)
    <div class="alert alert-warning shadow-sm">
        {{ $a }}
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('alertChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [
            {
                label: 'Recettes',
                data: {!! json_encode($recettesData) !!},
                borderColor: 'green',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Dépenses',
                data: {!! json_encode($depensesData) !!},
                borderColor: 'red',
                fill: false,
                tension: 0.3
            }
        ]
    }
});
</script>

<div class="alert alert-info mt-3">
    💡 Analyse automatique :
    @if(count($recettesData) > 0 && count($depensesData) > 0)

        @if(array_sum($depensesData) > array_sum($recettesData))
            Vos dépenses sont globalement supérieures à vos recettes 📉
        @else
            Vos finances sont équilibrées ou positives 📈
        @endif

    @endif
</div>

@endsection