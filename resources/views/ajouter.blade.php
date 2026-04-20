
    @extends('layouts.app')

    @section('content')
    
<div class="container mt-5">
    <h2 class="mb-4">Ajouter une transaction</h2>

    <form method="POST" action="{{ url('/ajouter') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-control">
                <option value="recette">Recette</option>
                <option value="depense">Dépense</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant</label>
            <input type="number" name="montant" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <br>
    <a href="{{ url('/transactions') }}" class="btn btn-success">Voir les transactions</a>
</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @endsection