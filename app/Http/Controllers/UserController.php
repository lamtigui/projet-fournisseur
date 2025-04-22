<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\SousCategorie;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function viewLogin()
    {
        if (auth()->check()) {
            return redirect()->route('dashboardSection');
        }

        return view('userAuth.login');
    }


    public function login(Request $request)
    {

        $request->validate(
            [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ],
            [
                'email.required' => 'L\'adresse e-mail est obligatoire!',
                'email.email' => 'Veuillez entrer une adresse e-mail valide!',
                'email.exists' => 'Cette adresse e-mail n\'est pas enregistrée!',
                'password.required' => 'Le mot de passe est obligatoire!',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères!',
            ]
        );

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'Le mot de passe est incorrect.',
            ])->withInput($request->except('password'));
        }

        $token = Auth::attempt($credentials);
        if ($token) {
            Auth::user();
            // return response()->json([
            //     'status'=>'success',
            //     'user'=>$user,
            //     'authorisation' => [
            //         'token' => $token,
            //         'type' => 'bearer',
            //     ]
            // ]);
            return redirect()->route('dashboardSection');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecte l'utilisateur

        $request->session()->invalidate(); // Invalide la session
        $request->session()->regenerateToken(); // Régénère le token CSRF

        return redirect('/'); // Redirige vers la page de connexion
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:155',
            'contact' => 'required|string|max:50|unique:users,contact',
            'adresse' => 'required|string|max:266',
            'email' => 'required|email|string|max:266|unique:users,email',
            'password' => 'required|string|min:9|confirmed',
            'password_confirmation' => 'required|string|min:9',
            'role' => 'required|string|in:super-admin,admin,utilisateur',
        ];

        $messages = [
            'name.required' => 'Le nom est obligatoire!',
            'name.string' => 'Le nom doit être de type string!',
            'contact.required' => 'Le contact est obligatoire!',
            'contact.string' => 'Le contact doit être de type string!',
            'adresse.required' => "L'adresse est obligatoire!",
            'adresse.string' => "L'adresse doit être de type string!",
            'email.required' => "L'émail est obligatoire!",
            'email.string' => "L'émail doit être de type string!",
            'email.unique' => "L'émail doit être unique!",
            'contact.unique' => "Le contact doit être unique!",
            'password.required' => "Le mot de passe est obligatoire!",
            'password.min' => "Le mot de passe doit avoir au minimum 9 caractères!",
            'password_confirmation.required' => "La confirmation est obligatoire!",
            'password.confirmed' => "La confirmation de mot de passe ne correspond pas!",
            'password_confirmation.min' => "Le mot de passe doit avoir au minimum 9 caractères!",
            'role.required' => "Le rôle est obligatoire!",
            'role.in' => "Le rôle sélectionné n'est pas valide!",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'default')
                ->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->contact = $request->contact;
        $user->adresse = $request->adresse;
        $user->role = $request->role;
        $user->email_verified_at = now();
        $user->remember_token = \Str::random(10);
        $user->save();

        ActivityLogController::logActivity("Ajout", "Compte",  " A ajouter " . $user->name);

        alert()->success('Succès', $user->name . " " . "a été enregistrée avec succès");

        return redirect()->to(url()->previous());
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $users = User::paginate($perPage);
        return view('myApp/admin/links/utilisateurs', compact('users', 'perPage'));
    }


    public function usersPdf()
    {

        $users = User::all();

        $options = new Options();
        $options->set('defaultFont', 'Courier'); // Définir une police
        $dompdf = new Dompdf($options);

        // Générer le contenu HTML
        $html = view('myApp/admin/pdf/utilisateurs', compact('users'))->render();

        // Charger le contenu dans DomPDF
        $dompdf->loadHtml($html);

        // Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Générer le PDF
        $dompdf->render();

        // Télécharger automatiquement le fichier PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="users-list.pdf"');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'LIKE', "%{$search}%")->orWhere('contact', 'LIKE', "%{$search}%")
            ->get();
        // dd($users->toArray());
        return response()->json($users);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        ActivityLogController::logActivity("Suppression", "Compte",  " A supprimé " . $user->name);
        return redirect()->to(url()->previous());
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view("myApp.admin.links.utilisateurs")
            ->with('user', $user);
    }

    public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:users,id',
        'newName' => 'required|string|max:155',
        'newContact' => 'required|string|max:50',
        'newAdresse' => 'required|string|max:266',
        'newEmail' => 'required|email|string|max:266',
        'newRole' => 'required|string|in:super-admin,admin,utilisateur',
        'newPassword' => 'nullable|string|min:9|confirmed',
        'newPassword_confirmation' => 'nullable|string|min:9',
    ], [
        'id.required' => "L'identifiant de l'utilisateur est obligatoire!",
        'id.exists' => "L'utilisateur spécifié n'existe pas!",
        'newName.required' => 'Le nom est obligatoire!',
        'newName.string' => 'Le nom doit être de type string!',
        'newContact.required' => 'Le contact est obligatoire!',
        'newContact.string' => 'Le contact doit être de type string!',
        'newAdresse.string' => "L'adresse doit être de type string!",
        'newAdresse.required' => "L'adresse est obligatoire!",
        'newEmail.required' => "L'émail est obligatoire!",
        'newEmail.string' => "L'émail doit être de type string!",
        'newRole.required' => "Le rôle est obligatoire!",
        'newRole.in' => "Le rôle sélectionné n'est pas valide!",
        'newPassword.min' => "Le mot de passe doit avoir au minimum 9 caractères!",
        'newPassword.confirmed' => "La confirmation de mot de passe ne correspond pas!",
        'newPassword_confirmation.min' => "Le mot de passe doit avoir au minimum 9 caractères!",
    ]);

    // Vérification des erreurs de validation
    if ($validator->fails()) {
        return redirect()->back()
            ->withInput()
            ->with('modalType', 'update')
            ->withErrors($validator)
            ->with('errors_displayed', true);
    }

    // Récupérer l'utilisateur à mettre à jour
    $user = User::find($request->id);

    // Mettre à jour les informations de l'utilisateur
    $user->name = $request->newName;
    $user->email = $request->newEmail;
    $user->contact = $request->newContact;
    $user->adresse = $request->newAdresse;
    $user->role = $request->newRole;
    
    // Mise à jour du mot de passe si spécifié
    if ($request->newPassword) {
        $user->password = Hash::make($request->newPassword);
    }

    // Générer un token de 10 caractères
    $user->remember_token = Str::random(10); // Génération d'un token de 10 caractères

    // Sauvegarder l'utilisateur avec les nouvelles informations
    $user->save();

    // Afficher une alerte de succès
    alert()->success('Succès', $user->name . " a été mis à jour avec succès");


    ActivityLogController::logActivity("Modification", "Compte",  " A modifié " . $user->name);
    // Rediriger vers la page précédente
    return redirect()->to(url()->previous());
}
}
