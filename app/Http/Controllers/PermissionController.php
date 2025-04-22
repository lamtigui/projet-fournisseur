<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function edit(User $user)
    {
        $permissions = $user->permission ?? new Permission();

        return view('admin.permissions.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, $userId)
    {

        if (auth()->user()->is_super_admin) {
            return redirect()->route('users.index')->with('success', 'Le super admin n\'a pas besoin de permissions.');
        }
        $user = User::findOrFail($userId);
    
        // Récupérer les permissions envoyées par le formulaire
        $permissionsData = $request->only([
            'can_see_prospects',
            'can_see_clients',
            'can_see_fournisseurs',
            'can_see_fournisseurs_clients',
        ]);
    
        // Initialiser un tableau avec les valeurs par défaut (false)
        $data = [
            'can_see_prospects' => false,
            'can_see_clients' => false,
            'can_see_fournisseurs' => false,
            'can_see_fournisseurs_clients' => false,
        ];

        
    
        // Mettre à jour les valeurs en fonction des permissions envoyées (cochees = true)
        foreach ($permissionsData as $key => $value) {
            if ($request->has($key)) {
                $data[$key] = true; // Si la checkbox est cochée, on met à true
            }
        }
    
        // Vérifier si l'utilisateur a déjà des permissions existantes
        $permission = $user->permission;
    
        // Si des permissions existent déjà, on les met à jour
        if ($permission) {
            $permission->update($data);
        } else {
            // Sinon, on crée une nouvelle ligne de permissions pour l'utilisateur
            $user->permission()->create($data);
        }
        ActivityLogController::logActivity(
            "Permission",
            "Compte",
            auth()->user()->name . " A mis à jour les permissions de " . $user->name
        );
    
        // Retourner à la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Permissions mises à jour avec succès.');
    }
    
}
