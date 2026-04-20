
        @extends('layouts.app')

    @section('content')

        
       <div class="container mt-5">

            <h2 class="mb-4">Liste des transactions</h2>

            <div class="mb-3">
                <h4>Résumé financier</h4>
                <p>Total Recettes : <strong>{{ $totalRecettes }}</strong></p>
                <p>Total Dépenses : <strong>{{ $totalDepenses }}</strong></p>
                <p>
                    Solde :
                    <span class="{{ $solde >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $solde }}
                    </span>
                </p>
            </div>

            <form method="GET" action="{{ url('/transactions') }}" class="mb-3">

                <select name="type" class="form-control w-25 d-inline">
                    <option value="">Tous</option>
                    <option value="recette">Recettes</option>
                    <option value="depense">Dépenses</option>
                </select>

                <button class="btn btn-primary">Filtrer</button>

            </form>

            <canvas id="myChart" width="400" height="200"></canvas>

        <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->type }}</td>
                    <td>{{ $t->montant }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ $t->date }}</td>
                    <td>
                        @if(!is_null($t->dette_id))
                            <button class="btn btn-secondary btn-sm" disabled>Modifier</button>
                            <button class="btn btn-secondary btn-sm" disabled>Supprimer</button>
                        @else
                            <a href="{{ url('/transactions/'.$t->id.'/edit') }}" class="btn btn-warning btn-sm">
                                Modifier
                            </a>

                            <form action="{{ url('/transactions/'.$t->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Voulez-vous supprimer ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ url('/ajouter') }}" class="btn btn-primary">Ajouter une transaction</a>

    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Recettes', 'Dépenses'],
                    datasets: [{
                        label: 'Montant',
                        data: [{{ $totalRecettes }}, {{ $totalDepenses }}],
                        borderWidth: 1
                    }]
                }
            });
        </script>
@endsection