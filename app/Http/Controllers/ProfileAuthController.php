<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class ProfileAuthController extends Controller
{
    public function showUpdateForm()
    {
        $user = Auth::user();
        return view('myApp.admin.links.profileUser', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        // Define basic validation rules
        $rules = [
            'newName' => 'required|string|max:155',
            'newContact' => 'required|string|max:50',
            'newAdresse' => 'required|string|max:266',
        ];

        // Add role rule only if the logged-in user is a super-admin
        if ($user->role === 'super-admin') {
            $rules['newRole'] = 'required|string|in:super-admin,admin,utilisateur';
        }

        $parametres = [
            'newName.required' => 'Le nom est obligatoire!',
            'newContact.required' => 'Le contact est obligatoire!',
            'newAdresse.required' => "L'adresse est obligatoire!",
            'newRole.required' => "Le rôle est obligatoire!",
            'newRole.in' => "Le rôle sélectionné n'est pas valide!",
        ];

        $validator = Validator::make($request->all(), $rules, $parametres);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('form', 'updateAuthUser')
                ->withErrors($validator);
        }

        // Check if the data is identical before updating
        $changes = false;
        $fieldsToUpdate = ['newName', 'newContact', 'newAdresse'];

        // If the user is a super-admin, include the role in the fields to update
        if ($user->role === 'super-admin') {
            $fieldsToUpdate[] = 'newRole';
        }

        foreach ($fieldsToUpdate as $field) {
            if ($user->{$field} !== $request->{$field}) {
                $changes = true;
                break;
            }
        }

        if (!$changes) {
            alert()->error('Erreur', 'Les mêmes informations existent déjà. Veuillez modifier au moins un champ.');
            return redirect()->back()->withInput();
        }

        try {
            // Update the user details
            $user->update([
                'name' => $request->newName,
                'contact' => $request->newContact,
                'adresse' => $request->newAdresse,
                // Only update role if the user is a super-admin
                'role' => $user->role === 'super-admin' ? $request->newRole : $user->role,
            ]);

            alert()->success('Succès', "La mise à jour a été effectuée avec succès.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Erreur : " . $e->getMessage());
        }

        return redirect()->back();
    }

    public function updateSecurity(Request $request)
    {
        // Vérifier si un des champs est vide
        if (empty($request->email) || empty($request->old_password) || empty($request->new_password) || empty($request->new_password_confirmation)) {
            alert()->error('Erreur', 'Tous les champs doivent être remplis.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        // Validation de l'email : structure correcte (présence de @ et .)
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            alert()->error('Erreur', 'Le champ email doit être une adresse email valide.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        // Vérifier que l'email est unique pour chaque compte utilisateur
        $emailExists = User::where('email', $request->email)->where('id', '!=', auth()->id())->exists();
        if ($emailExists) {
            alert()->error('Erreur', 'L\'e-mail doit être unique pour chaque compte utilisateur.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        $user = auth()->user();

        // Vérifier si l'ancien mot de passe est correct
        if (!Hash::check($request->old_password, $user->password)) {
            alert()->error('Erreur', 'L\'ancien mot de passe est incorrect.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        // Vérifier si le nouveau mot de passe est identique à l'ancien
        if ($request->old_password === $request->new_password) {
            alert()->error('Erreur', 'Le nouveau mot de passe ne peut pas être identique à l\'ancien.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        // Validation manuelle du nouveau mot de passe (confirmation et min 8 caractères)
        if (strlen($request->new_password) < 8) {
            alert()->error('Erreur', 'Le nouveau mot de passe doit comporter au moins 8 caractères.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            alert()->error('Erreur', 'La confirmation du mot de passe ne correspond pas.')->persistent('Fermer');
            return back()->withInput(); // Préserver les entrées du formulaire
        }

        // Si toutes les conditions sont remplies, mise à jour des informations
        try {
            $userData = [];

            if ($request->filled('email')) {
                $userData['email'] = $request->email;
            }

            if ($request->filled('new_password')) {
                $userData['password'] = Hash::make($request->new_password); // Hachage du mot de passe
            }

            if (!empty($userData)) {
                $user->update($userData);
                alert()->success('Succès', 'Les informations ont été mises à jour avec succès.');
                return back();
            } else {
                alert()->error('Erreur', 'Aucune modification n\'a été effectuée.');
                return back()->withErrors(['update' => 'Aucune modification n\'a été effectuée.']);
            }
        } catch (\Exception $e) {
            alert()->error('Erreur', 'Une erreur est survenue lors de la mise à jour des informations.');
            return back()->withErrors(['update' => 'Une erreur est survenue lors de la mise à jour des informations.']);
        }
    }
}