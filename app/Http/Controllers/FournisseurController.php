<?php

namespace App\Http\Controllers;

use App\Models\FournisseurClient;
use App\Models\Prospect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Fournisseur;
use App\Models\Categorie;
use App\Models\categorie_fournisseur;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;


class FournisseurController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'nom_fournisseur' => ['nullable', 'max:50', 'string'],
            'email_fournisseur' => ['nullable','email', 'string', 'max:266', 'unique:fournisseurs,email_fournisseur'],
            'tele_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseurs,tele_fournisseur'],
            'ville_fournisseur' => ['required', 'max:60', 'string'],
            'nomSociete_fournisseur' => ['nullable', 'max:200', 'unique:fournisseurs,nomSociete_fournisseur'],
            'GSM1_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseurs,GSM1_fournisseur'],
            'GSM2_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseurs,GSM2_fournisseur'],
            'lien_fournisseur' => ['nullable','url', 'string', 'max:266', 'unique:fournisseurs,lien_fournisseur'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        $messages = [
            // 'nom_fournisseur.required' => 'Le nom est obligatoire!',
            'nom_fournisseur.string' => 'Le nom doit être en chaine de caractère!',
            // 'email_fournisseur.required' => "L'émail est obligatoire!",
            'email_fournisseur.string' => "L'émail doit être en chaine de caractère!",
            'email_fournisseur.unique' => "L'émail doit être unique!",
            'ville_fournisseur.required' => "La ville est obligatoire!",
            'ville_fournisseur.string' => 'La ville doit être en chaine de caractère!',
            // 'tele_fournisseur.required' => 'Le contact est obligatoire!',
            'tele_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'tele_fournisseur.unique' => 'Le contact doit être unique!',
            'GSM1_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'GSM1_fournisseur.unique' => 'Le contact de la société doit être unique!',
            'GSM2_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'lien_fournisseur.string' => "Lien de la société doit être valide!",
            'nomSociete_fournisseur.unique' => "Le nom de la société doit être unique!",
            'categorie_id.required' => 'La catégorie est obligatoire!',
            'categorie_id.integer' => 'La catégorie doit être un entier!',
            'categorie_id.exists' => 'Cette catégorie n\'existe pas!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'default')
                ->withErrors($validator);
        }

        $fournisseur = new Fournisseur();
        $fournisseur->nom_fournisseur = $request->nom_fournisseur ?? '';
        $fournisseur->ville_fournisseur = $request->ville_fournisseur;
        $fournisseur->tele_fournisseur = $request->tele_fournisseur ?? '';
        $fournisseur->email_fournisseur = $request->email_fournisseur ?? '';
        $fournisseur->nomSociete_fournisseur = $request->nomSociete_fournisseur ?? '';
        $fournisseur->GSM1_fournisseur = $request->GSM1_fournisseur ?? '';
        $fournisseur->GSM2_fournisseur = $request->GSM2_fournisseur ?? '';
        $fournisseur->lien_fournisseur = $request->lien_fournisseur ?? '';
        $fournisseur->user_id = null;

        $fournisseur->groupId_fournisseur = Str::uuid();
        $fournisseur->save();

        $categorie = Categorie::find($request->categorie_id);
        $categorie->fournisseurs()->attach($fournisseur->id);

        ActivityLogController::logActivity("Ajout", "Fournisseur", "A ajouté " . $fournisseur->nomSociete_fournisseur);

        // Track the supplier addition
        $setting = Setting::where('key', 'suppliersTracking')->first();
        if ($setting) {


            // Increment the 'addedToday' count
            $setting->increment('addedToday');
        }

        alert()->success('Succès', $fournisseur->nom_fournisseur . " " . 'est enregistré avec succès.');

        return redirect()->to(url()->previous());
    }


    public function index(Request $request)
    {
        if (!auth()->user()->permission || !auth()->user()->permission->can_see_fournisseurs) {
            return view('errors.permission_denied');
        }
        

        $perPage = $request->get('per_page', 10);
        $fournisseurs = Fournisseur::with('categories', 'categorieFournisseur.categorie', 'utilisateur')->paginate($perPage);
        $categories = Categorie::with('sousCategories')->get();


        foreach ($fournisseurs as $fournisseur) {
            $fournisseur->allCategories = $fournisseur->allCategories();
        }

        $select = ['Clients', 'Prosperts', 'Fournisseur Client'];

        $utilisateurs = User::where('role', 'utilisateur')->get();

        return view('myApp.admin.links.fournisseurs', compact('fournisseurs', 'categories', 'select', 'perPage'));
    }

    public function updateUserFournisseur(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);


        $fournisseur = Fournisseur::findOrFail($id);

        $fournisseurs = Fournisseur::where('groupId_fournisseur', $fournisseur->groupId_fournisseur)->get();

        foreach ($fournisseurs as $f) {
            $f->user_id = $request->user_id ?? $f->user_id;
            $f->save();
        }

        ActivityLogController::logActivity("Contacté par", "Fournisseur","A modifié qui contacté  " . $fournisseur->nom_fournisseur);

        return redirect()->back();
    }

    public function updateRemarkFournisseur(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'remark' => ['nullable', 'string', function ($attribute, $value, $fail) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 100) {
                        $fail('La description ne doit pas dépasser 100 mots.');
                    }
                }]

            ],
            [
                "remark.string" => "La remarque doit etre de type chaine de caractere"
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'remark')
                ->withErrors($validator);
        }

        $fournisseur = Fournisseur::findOrFail($id);

        $fournisseurs = Fournisseur::where('groupId_fournisseur', $fournisseur->groupId_fournisseur)->get();

        foreach ($fournisseurs as $f) {
            $f->remark = $request->remark;
            $f->save();
        }

        ActivityLogController::logActivity("Remarque", "Fournisseur","A ajouté une remarque a  " . $fournisseur->nom_fournisseur);
        return redirect()->back();
    }

    public function fournisseursPdf()
    {

        $fournisseurs = Fournisseur::with('categorieFournisseur.categorie')->get();

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);


        $html = view('myApp/admin/pdf/fournisseurs', compact('fournisseurs'))->render();


        $dompdf->loadHtml($html);


        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();


        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="fournisseurs-list.pdf"');
    }








    public function destroy($id)
    {
        $fournisseur = Fournisseur::find($id);
        $fournisseur->delete();

        // Track the supplier deletion
        $setting = Setting::where('key', 'suppliersTracking')->first();
        if ($setting) {


            // Increment the 'deletedToday' count
            $setting->increment('deletedToday');
        }
        ActivityLogController::logActivity("Suppression", "Fournisseur","A supprimé" . $fournisseur->nom_fournisseur);
        return redirect()->to(url()->previous());
    }


    public function edit($id)
    {
        $fournisseur = Fournisseur::with('categories')->findOrFail($id);
        $categories = Categorie::all();
        return view('myApp.admin.links.fournisseurs_list', compact('fournisseur', 'categories', 'fournisseurs'));
    }

    public function update(Request $request)
    {
        $fournisseur = Fournisseur::find((int)$request->id);

        $rules = [
            'newNom_fournisseur' => ['nullable', 'max:50', 'string'],
            'newEmail_fournisseur' => ['nullable', 'string', 'max:266'],
            'newTele_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newVille_fournisseur' => ['required', 'max:60', 'string'],
            'newNomSociete_fournisseur' => ['nullable', 'max:200', 'string'],
            'newGSM1_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newGSM2_fournisseur' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newLien_fournisseur' => ['nullable', 'string', 'max:266'],
            'newCategorie_id' => ['required', 'integer', 'exists:categories,id']
        ];

        $messages = [
            // 'newNom_fournisseur.required' => 'Le nom est obligatoire!',
            'newNom_fournisseur.string' => 'Le nom doit être en chaine de caractère!',
            // 'newEmail_fournisseur.required' => "L'émail est obligatoire!",
            'newEmail_fournisseur.string' => "L'émail doit être en chaine de caractère!",
            // 'newTele_fournisseur.required' => 'Le contact est obligatoire!',
            'newTele_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'newNomSociete_fournisseur.string' => "Le nom de la société doit être en chaine de caractère!",
            'newVille_fournisseur.required' => "La ville est obligatoire!",
            'newVille_fournisseur.string' => 'La ville doit être en chaine de caractère!',
            'newGSM1_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'newGSM2_fournisseur.regex' => 'Le numéro de téléphone doit être valide!',
            'newLien_fournisseur.string' => 'Lien de la societe doit être en chaine de caractère!',
            'newCategorie_id.required' => 'La catégorie est obligatoire!',
            'newCategorie_id.integer' => 'La catégorie doit être un entier!',
            'newCategorie_id.exists' => 'Cette catégorie n\'existe pas!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'update')
                ->withErrors($validator)
                ->with('errors_displayed', true);
        }


        $nomSociety = $request->newNomSociete_fournisseur ?? '';
        $email = $request->newEmail_fournisseur ?? '';
        $name = $request->newNom_fournisseur ?? '';
        $tele = $request->newTele_fournisseur ?? '';
        $GSM1 = $request->newGSM1_fournisseur ?? '';
        $GSM2 = $request->newGSM2_fournisseur ?? '';
        $lien = $request->newLien_fournisseur ?? '';

        $newCategorieId = $request->newCategorie_id;

        $existingFournisseur = Fournisseur::where('nom_fournisseur', $name)
            ->where('email_fournisseur', $email)
            ->where('tele_fournisseur', $tele)
            ->where('ville_fournisseur', $request->newVille_fournisseur)
            ->where('nomSociete_fournisseur', $nomSociety)
            ->where('GSM1_fournisseur', $GSM1)
            ->where('GSM2_fournisseur', $GSM2)
            ->where('lien_fournisseur', $lien)
            ->whereHas('categories', function ($query) use ($newCategorieId) {
                $query->where('categories.id', $newCategorieId);
            })
            ->first();


        if ($existingFournisseur) {
            alert()->error('Erreur', 'Une version avec les mêmes informations existe déjà. Veuillez modifier au moins un champ.');
            return redirect()->back()->withInput();
        }


        if ($newCategorieId && !$this->hasOtherChanges($fournisseur, $request)) {
            $newFournisseur = $fournisseur->replicate();
            $newFournisseur->groupId_fournisseur = $fournisseur->groupId_fournisseur;
            $newFournisseur->version_fournisseur = $fournisseur->version_fournisseur + 1;
            $newFournisseur->save();

            $newFournisseur->categories()->sync([$newCategorieId]);

            alert()->success('Succès', "La catégorie a été modifiée et une nouvelle version a été créée.");
            return redirect()->back();
        }

        $fournisseur->nom_fournisseur = $request->newNom_fournisseur ?? '';
        $fournisseur->email_fournisseur = $request->newEmail_fournisseur ?? '';
        $fournisseur->tele_fournisseur = $request->newTele_fournisseur ?? '';
        $fournisseur->ville_fournisseur = $request->newVille_fournisseur;
        $fournisseur->GSM1_fournisseur = $request->newGSM1_fournisseur ?? '';
        $fournisseur->GSM2_fournisseur = $request->newGSM2_fournisseur ?? '';
        $fournisseur->lien_fournisseur = $request->newLien_fournisseur ?? '';
        $fournisseur->nomSociete_fournisseur = $request->newNomSociete_fournisseur ?? '';

        if ($fournisseur->save()) {
            alert()->success('Succès', 'Le fournisseur a été mis à jour avec succès.');
        }


        $fournisseursSimilaires = Fournisseur::where('groupId_fournisseur', $fournisseur->groupId_fournisseur)->get();

        foreach ($fournisseursSimilaires as $similarFournisseur) {
            $similarFournisseur->nom_fournisseur = $request->newNom_fournisseur ?? '';
            $similarFournisseur->email_fournisseur = $request->newEmail_fournisseur ?? '';
            $similarFournisseur->tele_fournisseur = $request->newTele_fournisseur ?? '';
            $similarFournisseur->ville_fournisseur = $request->newVille_fournisseur;
            $similarFournisseur->nomSociete_fournisseur = $request->newNomSociete_fournisseur ?? '';
            $similarFournisseur->GSM1_fournisseur = $request->newGSM1_fournisseur ?? '';
            $similarFournisseur->GSM2_fournisseur = $request->newGSM2_fournisseur ?? '';
            $similarFournisseur->lien_fournisseur = $request->newLien_fournisseur ?? '';
            if ($similarFournisseur->save()) {
                alert()->success('Succès', 'Le fournisseur a été mis à jour avec succès.');
            }
        }

        ActivityLogController::logActivity("Modification", "Fournisseur", "A modifié " . $fournisseur->nom_fournisseur);

        return redirect()->back();
    }


    public function search(Request $request)
    {
        $select = ['Clients', 'Prosperts', 'Fournisseur Client'];
        $search = $request->input('search');
        $supplier = Fournisseur::with(['categories.sousCategories', 'utilisateur'])
            ->where('tele_fournisseur', 'LIKE', "%{$search}%")
            ->orWhere('nom_fournisseur', 'LIKE', "%{$search}%")
            ->orWhere('nomSociete_fournisseur', 'LIKE', "%{$search}%")



            ->get();

        // foreach ($supplier as $supp) {
        //         $supp->category_id = $supp->categories->first()?->id ?? '';
        // };
        return response()->json([
            'suppliers' => $supplier,
            'selectOptions' => $select
        ]);
    }


    private function hasOtherChanges($fournisseur, $request)
    {
        return $fournisseur->nom_fournisseur !== ($request->newNom_fournisseur ?? '') ||
            $fournisseur->email_fournisseur !== ($request->newEmail_fournisseur ?? '') ||
            $fournisseur->tele_fournisseur !== ($request->newTele_fournisseur ?? '') ||
            $fournisseur->ville_fournisseur !== $request->newVille_fournisseur ||
            $fournisseur->nomSociete_fournisseur !== ($request->newNomSociete_fournisseur ?? '') ||
            $fournisseur->GSM1_fournisseur !== ($request->newGSM1_fournisseur ?? '') ||
            $fournisseur->GSM2_fournisseur !== ($request->newGSM2_fournisseur ?? '') ||
            $fournisseur->lien_fournisseur !== ($request->newLien_fournisseur ?? '');
    }

    public function fournisseur(Request $request, $id)
    {
        $selectedStatus = $request->input('status');
        $fournisseur = Fournisseur::find($id);
        $fournisseursGroup = Fournisseur::where('groupId_fournisseur', $fournisseur->groupId_fournisseur)->get();

        // Set initial $tiersChange value
        $tiersChange = 0;

        if ($selectedStatus === 'Clients') {
            foreach ($fournisseursGroup as $fournisseurItem) {
                $prospect = new Prospect();
                $prospect->nom_prospect = $fournisseurItem->nom_fournisseur;
                $prospect->email_prospect = $fournisseurItem->email_fournisseur;
                $prospect->tele_prospect = $fournisseurItem->tele_fournisseur;
                $prospect->GSM1_prospect = $fournisseurItem->GSM1_fournisseur;
                $prospect->GSM2_prospect = $fournisseurItem->GSM2_fournisseur;
                $prospect->lien_prospect = $fournisseurItem->lien_fournisseur;
                $prospect->ville_prospect = $fournisseurItem->ville_fournisseur;
                $prospect->nomSociete_prospect = $fournisseurItem->nomSociete_fournisseur;
                $prospect->user_id = $fournisseurItem->user_id;
                $prospect->remark = $fournisseurItem->remark;
                $prospect->groupId_prospect = $fournisseurItem->groupId_fournisseur;
                $prospect->save();

                if ($fournisseurItem->categories) {
                    foreach ($fournisseurItem->categories as $category) {
                        $prospect->categories()->attach($category->id);
                    }
                }

                $fournisseurItem->delete();

                // Increment tiersChange for Tiers (Prospect)
                $tiersChange++;
            }

            // Update addedToday in settings for tiersTracking
            $setting = Setting::where('key', 'tiersTracking')->first();
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'tiersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $setting->increment('addedToday', $tiersChange);

            // Update deletedToday in settings for suppliersTracking
            $suppliersTracking = Setting::where('key', 'suppliersTracking')->first();
            if (!$suppliersTracking) {
                $suppliersTracking = Setting::create([
                    'key' => 'suppliersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $suppliersTracking->increment('deletedToday', $tiersChange);
        } else if ($selectedStatus === 'Prosperts') {
            foreach ($fournisseursGroup as $fournisseurItem) {
                $client = new Client();
                $client->nom_client = $fournisseurItem->nom_fournisseur;
                $client->email_client = $fournisseurItem->email_fournisseur;
                $client->tele_client = $fournisseurItem->tele_fournisseur;
                $client->GSM1_client = $fournisseurItem->GSM1_fournisseur;
                $client->GSM2_client = $fournisseurItem->GSM2_fournisseur;
                $client->lien_client = $fournisseurItem->lien_fournisseur;
                $client->ville_client = $fournisseurItem->ville_fournisseur;
                $client->nomSociete_client = $fournisseurItem->nomSociete_fournisseur;
                $client->user_id = $fournisseurItem->user_id;
                $client->remark = $fournisseurItem->remark;
                $client->groupId_client = $fournisseurItem->groupId_fournisseur;
                $client->save();

                if ($fournisseurItem->categories) {
                    foreach ($fournisseurItem->categories as $category) {
                        $client->categories()->attach($category->id);
                    }
                }

                $fournisseurItem->delete();

                // Increment tiersChange for Client
                $tiersChange++;
            }

            // Update addedToday in settings for clientsTracking
            $setting = Setting::where('key', 'clientsTracking')->first();
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'clientsTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $setting->increment('addedToday', $tiersChange);

            // Update deletedToday in suppliersTracking
            $suppliersTracking = Setting::where('key', 'suppliersTracking')->first();
            if (!$suppliersTracking) {
                $suppliersTracking = Setting::create([
                    'key' => 'suppliersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $suppliersTracking->increment('deletedToday', $tiersChange);
        } else if ($selectedStatus === 'Fournisseur Client') {
            foreach ($fournisseursGroup as $fournisseurItem) {
                $fc = new FournisseurClient();
                $fc->nom_fournisseurClient = $fournisseurItem->nom_fournisseur;
                $fc->email_fournisseurClient = $fournisseurItem->email_fournisseur;
                $fc->tele_fournisseurClient = $fournisseurItem->tele_fournisseur;
                $fc->GSM1_fournisseurClient = $fournisseurItem->GSM1_fournisseur;
                $fc->GSM2_fournisseurClient = $fournisseurItem->GSM2_fournisseur;
                $fc->lien_fournisseurClient = $fournisseurItem->lien_fournisseur;
                $fc->ville_fournisseurClient = $fournisseurItem->ville_fournisseur;
                $fc->nomSociete_fournisseurClient = $fournisseurItem->nomSociete_fournisseur;
                $fc->user_id = $fournisseurItem->user_id;
                $fc->remark = $fournisseurItem->remark;
                $fc->groupId_fournisseurClient = $fournisseurItem->groupId_fournisseur;
                $fc->save();

                if ($fournisseurItem->categories) {
                    foreach ($fournisseurItem->categories as $category) {
                        $fc->categories()->attach($category->id);
                    }
                }

                $fournisseurItem->delete();

                // Increment tiersChange for Fournisseur Client
                $tiersChange++;
            }

            // Update addedToday in settings for fournisseurClientTracking
            $setting = Setting::where('key', 'fournisseurClientTracking')->first();
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'fournisseurClientTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $setting->increment('addedToday', $tiersChange);

            // Update deletedToday in suppliersTracking
            $suppliersTracking = Setting::where('key', 'suppliersTracking')->first();
            if (!$suppliersTracking) {
                $suppliersTracking = Setting::create([
                    'key' => 'suppliersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }
            $suppliersTracking->increment('deletedToday', $tiersChange);
        }
        ActivityLogController::logActivity("Transfert", "Fournisseur","A transféré " . $tiersChange . " fournisseurs à " . $selectedStatus);
        return redirect()->to(url()->previous());
    }
}
