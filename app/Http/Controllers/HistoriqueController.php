<?php

namespace App\Http\Controllers;
use App\Models\Historique;


use Illuminate\Http\Request;
use App\Models\User;

class HistoriqueController extends Controller
{
    public function showHistorique()
    {
        // Récupérer tous les historiques avec les utilisateurs associés et trier par login_at (desc)
        $historiques = \App\Models\Historique::with('user')
            ->orderBy('login_at', 'desc')
            ->get();

        return view('myApp.admin.links.historiques', compact('historiques'));
    }
    public function index(Request $request)
    {
        $query = Historique::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }
        $historiques = $query->orderBy('login_at', 'desc')->paginate(10);
        

        return view('myApp.admin.links.historiques', compact('historiques'));
    }
}
