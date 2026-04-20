@extends('layouts.app')

@section('content')

<h2>Modifier Transaction</h2>

{{-- Messages --}}
@if(session('error'))
    <div style="color:red;">{{ session('error') }}</div>
@endif

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

<form action="{{ url('/transactions/'.$transaction->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Type</label><br>
    <select name="type">
        <option value="recette" {{ $transaction->type == 'recette' ? 'selected' : '' }}>Recette</option>
        <option value="depense" {{ $transaction->type == 'depense' ? 'selected' : '' }}>Dépense</option>
    </select><br><br>

    <label>Montant</label><br>
    <input type="number" name="montant" value="{{ $transaction->montant }}"><br><br>

    <label>Description</label><br>
    <input type="text" name="description" value="{{ $transaction->description }}"><br><br>

    <label>Date</label><br>
    <input type="date" name="date" value="{{ $transaction->date }}"><br><br>

    <button type="submit" class="btn btn-success">Modifier</button>
</form>

@endsection