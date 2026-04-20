<?php

namespace App\Http\Controllers;

use App\Models\Dette;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        return view('ajouter');
    }



  public function index(Request $request)
{
    $query = Transaction::query();

    // Filtre
    if ($request->type) {
        $query->where('type', $request->type);
    }

    $transactions = $query->get();

    $totalRecettes = $transactions->where('type', 'recette')->sum('montant');
    $totalDepenses = $transactions->where('type', 'depense')->sum('montant');

    $solde = $totalRecettes - $totalDepenses;

    return view('transactions', compact('transactions', 'totalRecettes', 'totalDepenses', 'solde'));
}



public function alertes()
{
    $transactions = Transaction::all();
    $dettes = Dette::all();

    $totalRecettes = $transactions->where('type', 'recette')->sum('montant');
    $totalDepenses = $transactions->where('type', 'depense')->sum('montant');
    $solde = $totalRecettes - $totalDepenses;

    $alertes = [];

    // ⚠️ Dépenses > Recettes
    if ($totalDepenses > $totalRecettes) {
        $alertes[] = "⚠️ Vos dépenses dépassent vos revenus";
    }

    // ⚠️ Solde faible
    if ($solde < 10000) {
        $alertes[] = "⚠️ Votre solde est faible";
    }

    // ⚠️ Dettes en retard
    foreach ($dettes as $d) {
        if ($d->statut != 'payé' && $d->date_echeance && now()->gt($d->date_echeance)) {
            $alertes[] = "⚠️ Dette en retard : " . $d->nom;
        }
    }

    // 💡 Recommandations
    if ($totalDepenses > $totalRecettes) {
        $alertes[] = "💡 Réduisez vos dépenses inutiles";
    }



    // 🔥 données pour graphique (par jour)
    $stats = Transaction::select(
            DB::raw('DATE(date) as jour'),
            DB::raw("SUM(CASE WHEN type='recette' THEN montant ELSE 0 END) as recettes"),
            DB::raw("SUM(CASE WHEN type='depense' THEN montant ELSE 0 END) as depenses")
        )
        ->groupBy('jour')
        ->orderBy('jour')
        ->get();

    // transformer en tableaux
    $labels = $stats->pluck('jour')->toArray();
    $recettesData = $stats->pluck('recettes')->toArray();
    $depensesData = $stats->pluck('depenses')->toArray();

    return view('alertes.index', compact(
    'alertes',
    'labels',
    'recettesData',
    'depensesData'
));
}


public function rapports(Request $request)
{
    // 📅 filtre (mois ou jour)
    $date = $request->date;
    $mois = $request->mois;

    $query = Transaction::query();

    if ($date) {
        $query->whereDate('date', $date);
    }

    if ($mois) {
        $query->whereMonth('date', $mois);
    }

    $transactions = $query->get();

    // 💰 totaux FILTRÉS
    $recettes = $transactions->where('type', 'recette')->sum('montant');
    $depenses = $transactions->where('type', 'depense')->sum('montant');

    // 🔥 TOP DEPENSE
    $topDepense = $transactions
        ->where('type', 'depense')
        ->sortByDesc('montant')
        ->first();

    // 🔥 TOP REVENU
    $topRevenu = $transactions
        ->where('type', 'recette')
        ->sortByDesc('montant')
        ->first();

    // =========================
    // ✅ AJOUT IMPORTANT ICI
    // =========================

    // 📅 AUJOURD'HUI
    $recettesJour = Transaction::whereDate('date', now())
        ->where('type', 'recette')
        ->sum('montant');

    $depensesJour = Transaction::whereDate('date', now())
        ->where('type', 'depense')
        ->sum('montant');

    // 📆 MOIS ACTUEL
    $recettesMois = Transaction::whereMonth('date', now()->month)
        ->where('type', 'recette')
        ->sum('montant');

    $depensesMois = Transaction::whereMonth('date', now()->month)
        ->where('type', 'depense')
        ->sum('montant');

    // =========================

    // 💡 ANALYSE INTELLIGENTE
    $analyse = [];

    if ($depenses > $recettes) {
        $analyse[] = "⚠️ Vous dépensez plus que vous gagnez";
    }

    if ($topDepense) {
        $analyse[] = "💡 Dépense élevée : " . $topDepense->description;
    }

    if ($recettes == 0) {
        $analyse[] = "⚠️ Aucun revenu enregistré";
    }

    return view('rapports.index', compact(
        'recettes',
        'depenses',
        'topDepense',
        'topRevenu',
        'analyse',

        // ✅ IMPORTANT (ajout ici)
        'recettesJour',
        'depensesJour',
        'recettesMois',
        'depensesMois'
    ));
}


public function dashboard()
{
    $transactions = Transaction::all();
    $dettes = Dette::all();

    $totalRecettes = $transactions->where('type', 'recette')->sum('montant');
    $totalDepenses = $transactions->where('type', 'depense')->sum('montant');
    $solde = $totalRecettes - $totalDepenses;

    // 🔥 ANALYSE MENSUELLE
    $mois = Carbon::now()->month;

    $transactionsMois = Transaction::whereMonth('date', $mois)->get();

    $maxDepense = $transactionsMois->where('type', 'depense')->max('montant');
    $maxRevenu = $transactionsMois->where('type', 'recette')->max('montant');

    $meilleurJour = $transactionsMois
        ->groupBy('date')
        ->map(fn($g) => $g->sum('montant'))
        ->sortDesc()
        ->keys()
        ->first();

    return view('dashboard', compact(
        'transactions',
        'dettes',
        'totalRecettes',
        'totalDepenses',
        'solde',
        'maxDepense',
        'maxRevenu',
        'meilleurJour'
    ));
}



public function edit($id)
{
    $transaction = Transaction::findOrFail($id);

    // 🔒 Bloquer modification si liée à une dette
    if (!is_null($transaction->dette_id)) {
        return redirect('/transactions')
            ->with('error', '❌ Impossible de modifier une transaction liée à une dette');
    }

    return view('edit', compact('transaction'));
}



public function update(Request $request, $id)
{
    $transaction = Transaction::findOrFail($id);

    // 🔒 Sécurité
    if (!is_null($transaction->dette_id)) {
        return redirect('/transactions')
            ->with('error', '❌ Modification interdite pour une dette');
    }

    // ✅ Validation
    if ($request->montant <= 0) {
        return redirect()->back()->with('error', 'Montant invalide');
    }

    // ✅ Mise à jour
    $transaction->type = $request->type;
    $transaction->montant = $request->montant;
    $transaction->description = $request->description;
    $transaction->date = $request->date;

    $transaction->save();

    return redirect('/transactions')->with('success', '✅ Transaction modifiée');
}




public function destroy($id)
{
    $transaction = Transaction::findOrFail($id);

    // 🔒 Bloquer suppression si dette
    if (!is_null($transaction->dette_id)) {
        return redirect('/transactions')
            ->with('error', '❌ Suppression interdite pour une dette');
    }

    $transaction->delete();

    return redirect('/transactions')->with('success', '✅ Transaction supprimée');
}




    public function store(Request $request)
{
    Transaction::create([
        'type' => $request->type,
        'montant' => $request->montant,
        'description' => $request->description,
        'date' => $request->date,
    ]);

    return redirect('/ajouter');
}



}

