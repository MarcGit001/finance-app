<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Dette;
use Illuminate\Http\Request;

class DetteController extends Controller
{
public function index()
{
    $dettes = Dette::all();

    // 🔥 TOTAL DETTES RESTANTES
    $totalDettesRestantes = $dettes
        ->where('statut', '!=', 'payé')
        ->sum(function($d){
            return $d->montant - $d->montant_paye;
        });

    // 🔥 TOTAL FACTURES
    $totalFactures = $dettes
        ->where('type', 'facture')
        ->where('statut', '!=', 'payé')
        ->sum(function($d){
            return $d->montant - $d->montant_paye;
        });

    return view('dettes.index', compact(
        'dettes',
        'totalDettesRestantes',
        'totalFactures'
    ));
}


public function payer($id)
{
    $dette = Dette::findOrFail($id);

    $totalRecettes = Transaction::where('type', 'recette')->sum('montant');
    $totalDepenses = Transaction::where('type', 'depense')->sum('montant');
    $solde = $totalRecettes - $totalDepenses;

    if ($dette->montant > $solde) {
        return back()->with('error', 'Solde insuffisant ❌');
    }

    $dette->statut = 'payé';
    $dette->montant_paye = $dette->montant;

    $dette->save();

    Transaction::create([
        'type' => 'depense',
        'montant' => $dette->montant,
        'description' => 'Paiement total dette : '.$dette->nom,
        'date' => now(),
        'dette_id' => $dette->id
    ]);

    return redirect('/dettes')->with('success', 'Dette payée ✅');
}


public function paiementPartiel(Request $request, $id)
{
    $dette = Dette::findOrFail($id);

    $montant = $request->montant;

    // 🔥 récupérer solde
    $totalRecettes = Transaction::where('type', 'recette')->sum('montant');
    $totalDepenses = Transaction::where('type', 'depense')->sum('montant');
    $solde = $totalRecettes - $totalDepenses;

    $reste = $dette->montant - $dette->montant_paye;

    // ❌ montant invalide
    if ($montant <= 0) {
        return back()->with('error', 'Montant invalide ❌');
    }

    // ❌ dépasse la dette
    if ($montant > $reste) {
        return back()->with('error', 'Montant dépasse le reste à payer ❌');
    }

    // ❌ solde insuffisant
    if ($montant > $solde) {
        return back()->with('error', 'Solde insuffisant ❌');
    }

    // ✅ paiement OK
    $dette->montant_paye += $montant;

    if ($dette->montant_paye >= $dette->montant) {
        $dette->statut = 'payé';
    } else {
        $dette->statut = 'partiel';
    }

    $dette->save();

    // 🔥 enregistrer comme dépense
    Transaction::create([
        'type' => 'depense',
        'montant' => $montant,
        'description' => 'Paiement dette : '.$dette->nom,
        'date' => now(),
        'dette_id' => $dette->id
    ]);

    return redirect('/dettes')->with('success', 'Paiement effectué ✅');
}


public function store(Request $request)
{
    $dette = new Dette();

    $dette->nom = $request->nom;
    $dette->montant = $request->montant;
    $dette->type = $request->type;
    $dette->date_echeance = $request->date_echeance;
    $dette->date = $request->date;

    $dette->statut = 'non payé';
    $dette->montant_paye = 0;

    $dette->save();

    return redirect('/dettes');
}


public function create()
{
    return view('dettes.create');
}

}
