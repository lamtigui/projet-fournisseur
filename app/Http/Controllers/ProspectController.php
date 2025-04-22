<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Client;
use App\Models\FournisseurClient;
use App\Models\Prospect;
use App\Models\Fournisseur;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Setting;


class ProspectController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'nom_prospect' => ['nullable', 'max:50', 'string'],
            'email_prospect' => ['nullable','email', 'string', 'max:266', 'unique:prospects,email_prospect'],
            'lien_prospect' => ['nullable','url', 'string', 'max:266', 'unique:prospects,lien_prospect'],
            'tele_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:prospects,tele_prospect'],
            'ville_prospect' => ['required', 'max:60', 'string'],
            'nomSociete_prospect' => ['nullable', 'max:200', 'unique:prospects,nomSociete_prospect'],
            'GSM1_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:prospects,GSM1_prospect'],
            'GSM2_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:prospects,GSM2_prospect'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        $messages = [
            // 'nom_prospect.required' => 'Le nom est obligatoire!',
            'nom_prospect.string' => 'Le nom doit être en chaine de caractère!',
            // 'email_prospect.required' => "L'émail est obligatoire!",
            'email_prospect.string' => "L'émail doit être en chaine de caractère!",
            'email_prospect.unique' => "L'émail doit être unique!",
            'lien_prospect.string' => "Lien doit être en chaine de caractère!",
            'ville_prospect.required' => "La ville est obligatoire!",
            'ville_prospect.string' => 'La ville doit être en chaine de caractère!',
            // 'tele_prospect.required' => 'Le contact est obligatoire!',
            'tele_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'tele_prospect.unique' => 'Le contact doit être unique!',
            'GSM1_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'GSM1_prospect.unique' => 'Le contact de la societe doit être unique!',
            'GSM2_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'GSM2_prospect.unique' => 'Le contact de la societe doit être unique!',
            'nomSociete_prospect.unique' => "Le nom de la société doit être unique!",
            'categorie_id.required' => 'La catégorie est obligatoire!',
            'categorie_id.integer' => 'La catégorie doit être un entier!',
            'categorie_id.exists' => 'Cette catégorie n\'existe pas!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'default')
                ->withErrors($validator);
        }

        $prospect = new Prospect();
        $prospect->nom_prospect = $request->nom_prospect ?? '';
        $prospect->GSM1_prospect = $request->GSM1_prospect ?? '';
        $prospect->GSM2_prospect = $request->GSM2_prospect ?? '';
        $prospect->lien_prospect = $request->lien_prospect ?? '';
        $prospect->ville_prospect = $request->ville_prospect;
        $prospect->tele_prospect = $request->tele_prospect ?? '';
        $prospect->email_prospect = $request->email_prospect ?? '';
        $prospect->nomSociete_prospect = $request->nomSociete_prospect ?? '';

        $prospect->groupId_prospect = Str::uuid();
        $prospect->save();

        $categorie = Categorie::find($request->categorie_id);
        $categorie->prospects()->attach($prospect->id);

        ActivityLogController::logActivity("Ajout", "Clients",  " A ajouté " . $prospect->nom_prospect );

        // Update the 'addedToday' in the settings table
        $setting = Setting::where('key', 'tiersTracking')->first();

        // If settings are not found, initialize them
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'tiersTracking',
                'value' => 0,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Increment the 'addedToday' counter
        $setting->increment('addedToday');

        alert()->success('succès', $prospect->nom_prospect . " " . 'a été enregistrée avec succès.');
        return redirect()->to(url()->previous());
    }

    public function updateUserProspect(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);


        $prospect = Prospect::findOrFail($id);

        $prospects = Prospect::where('groupId_prospect', $prospect->groupId_prospect)->get();

        foreach ($prospects as $p) {
            $p->user_id = $request->user_id ?? $p->user_id;
            $p->save();
        }


        ActivityLogController::logActivity("Contacté par", "Clients","A modifié qui contacté  " . $prospect->nom_prospect);
        return redirect()->back();
    }

    public function updateRemarkProspect(Request $request, $id)
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

        $prospect = Prospect::findOrFail($id);

        $prospects = Prospect::where('groupId_prospect', $prospect->groupId_prospect)->get();

        foreach ($prospects as $p) {
            $p->remark = $request->remark;
            $p->save();
        }
        
        ActivityLogController::logActivity("Remarque", "Clients","A ajouté une remarque a  " . $prospect->nom_prospect);

        return redirect()->back();
    }




    public function index(Request $request)
    {
        if (!auth()->user()->permission || !auth()->user()->permission->can_see_prospects) {
            return view('errors.permission_denied');
        }
        

        $perPage = $request->get('per_page', 10);
        $prospects = Prospect::with('categories', 'categorieProspects.categorie', 'utilisateur')->paginate($perPage);

        $categories = Categorie::with('sousCategories')->get();

        foreach ($prospects as $prospect) {
            $prospect->allCategories = $prospect->allCategories();
        }

        $select = ['Fournisseur', 'Prosperts', 'Fournisseur Client'];

        return view('myApp.admin.links.prospects', compact('prospects', 'categories', 'select', 'perPage'));
    }

    public function prospectsPdf()
    {
        $prospects = Prospect::with('categorieProspects.categorie')->get();

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        $html = view('myApp/admin/pdf/prospects', compact('prospects'))->render();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="prospects-list.pdf"');
    }




    public function destroy($id)
    {
        $prospect = Prospect::find($id);

        if ($prospect) {
            $prospect->delete();

            // Update the 'deletedToday' in the settings table
            $setting = Setting::where('key', 'tiersTracking')->first();

            // If settings are not found, initialize them
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'tiersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }

            // Increment the 'deletedToday' counter
            $setting->increment('deletedToday');
        }

        ActivityLogController::logActivity("Suppression", "Clients",  " A supprimé  " . $prospect->nom_prospect );
        return redirect()->to(url()->previous());
    }





    public function update(Request $request)
    {

        $prospect = Prospect::find((int)$request->id);

        $rules = [
            'newNom_prospect' => ['nullable', 'max:50', 'string'],
            'newEmail_prospect' => ['nullable','string', 'max:266'],
            'newTele_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newVille_prospect' => ['required', 'max:60', 'string'],
            'newNomSociete_prospect' => ['nullable', 'max:200'],
            'newGSM1_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newGSM2_prospect' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newLien_prospect' => ['nullable','string', 'max:266'],
            'newCategorie_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        $messages = [
            // 'newNom_prospect.required' => 'Le nom est obligatoire!',
            'newNom_prospect.string' => 'Le nom doit être en chaine de caractère!',
            // 'newEmail_prospect.required' => "L'émail est obligatoire!",
            'newEmail_prospect.string' => "L'émail doit être en chaine de caractère!",
            'newVille_prospect.required' => "La ville est obligatoire!",
            'newVille_prospect.string' => 'La ville doit être en chaine de caractère!',
            // 'newTele_prospect.required' => 'Le contact est obligatoire!',
            'newTele_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'newGSM1_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'newGSM2_prospect.regex' => 'Le numéro de téléphone doit être valide!',
            'newLien_prospect.string' => "Lien doit être en chaine de caractère!",
            'categorie_id.required' => 'La catégorie est obligatoire!',
            'newCategorie_id.integer' => 'La catégorie doit être un entier!',
            'newCategorie_id.exists' => 'Cette catégorie n\'existe pas!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('modalType', 'update')
                ->withErrors($validator);
        }

        $nomSociety = $request->newNomSociete_prospect ?? '';
        $email = $request->newEmail_prospect ?? '';
        $name = $request->newNom_prospect ?? '';
        $tele = $request->newTele_prospect ?? '';
        $GSM1 = $request->newGSM1_prospect ?? '';
        $GSM2 = $request->newGSM2_prospect ?? '';
        $lien = $request->newLien_prospect ?? '';
        $newCategorieId = $request->newCategorie_id;
        $existingProspect = Prospect::where('nom_prospect', $name)
            ->where('email_prospect', $email)
            ->where('tele_prospect', $tele)
            ->where('ville_prospect', $request->newVille_prospect)
            ->where('nomSociete_prospect', $nomSociety)
            ->where('GSM1_prospect', $GSM1)
            ->where('GSM2_prospect', $GSM2)
            ->where('lien_prospect', $lien)
            ->whereHas('categories', function ($query) use ($newCategorieId) {
                $query->where('categories.id', $newCategorieId);
            })
            ->first();

        if ($existingProspect) {
            alert()->error('Erreur', 'Une version avec les mêmes informations existe déjà. Veuillez modifier au moins un champ.');
            return redirect()->back()->withInput();
        }

        if ($newCategorieId && !$this->hasOtherChanges($prospect, $request)) {
            $newProspect = $prospect->replicate();
            $newProspect->groupId_prospect = $prospect->groupId_prospect;
            $newProspect->version_prospect = $prospect->version_prospect + 1;
            $newProspect->save();

            $newProspect->categories()->sync([$newCategorieId]);

            alert()->success('Succès', "La catégorie a été modifiée et une nouvelle version a été créée.");
            return redirect()->back();
        }

        $prospect->nom_prospect = $request->newNom_prospect ?? '';
        $prospect->email_prospect = $request->newEmail_prospect ?? '';
        $prospect->tele_prospect = $request->newTele_prospect ?? '';
        $prospect->ville_prospect = $request->newVille_prospect;
        $prospect->nomSociete_prospect = $request->newNomSociete_prospect ?? '';
        $prospect->GSM1_prospect = $request->newGSM1_prospect ?? '';
        $prospect->GSM2_prospect = $request->newGSM2_prospect ?? '';
        $prospect->lien_prospect = $request->newLien_prospect ?? '';

        if ($prospect->save()) {
            alert()->success('Succès', 'Le tier a été mis à jour avec succès.');
        }

        $prospectsSimilaires = Prospect::where('groupId_prospect', $prospect->groupId_prospect)
            ->where('id', '!=', $prospect->id)
            ->get();

        foreach ($prospectsSimilaires as $similarProspect) {
            $similarProspect->nom_prospect = $request->newNom_prospect ?? '';
            $similarProspect->email_prospect = $request->newEmail_prospect ?? '';
            $similarProspect->tele_prospect = $request->newTele_prospect ?? '';
            $similarProspect->ville_prospect = $request->newVille_prospect;
            $similarProspect->nomSociete_prospect = $request->newNomSociete_prospect ?? '';
            $similarProspect->GSM1_prospect = $request->newGSM1_prospect ?? '';
            $similarProspect->GSM2_prospect = $request->newGSM2_prospect ?? '';
            $similarProspect->lien_prospect = $request->newLien_prospect ?? '';
            if ($similarProspect->save()) {
                alert()->success('Succès', 'Le tier a été mis à jour avec succès.');
            };
        }

        ActivityLogController::logActivity("Modification", "Clients",  " A modifié  " . $prospect->nom_prospect );
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $select = ['Fournisseur', 'Prosperts', 'Fournisseur Client'];
        $search = $request->input('search');
        $prospect = Prospect::with(['categories.sousCategories', 'utilisateur'])
            ->where('nomSociete_prospect', 'LIKE', "%{$search}%")
            ->orWhere('tele_prospect', 'LIKE', "%{$search}%")
            ->orWhere('nom_prospect', 'LIKE', "%{$search}%")
            ->get();
        return response()->json([
            'prospects' => $prospect,
            'selectOptions' => $select
        ]);
    }


    private function hasOtherChanges($prospect, $request)
    {

        return $prospect->nom_prospect !== ($request->newNom_prospect ?? '') ||
            $prospect->email_prospect !== ($request->newEmail_prospect ?? '') ||
            $prospect->tele_prospect !== ($request->newTele_prospect ?? '') ||
            $prospect->ville_prospect !== $request->newVille_prospect ||
            $prospect->nomSociete_prospect !== ($request->newNomSociete_prospect ?? '') ||
            $prospect->GSM1_prospect !== ($request->newGSM1_prospect ?? '') ||
            $prospect->GSM2_prospect !== ($request->newGSM2_prospect ?? '') ||
            $prospect->lien_prospect !== ($request->newLien_prospect ?? '');
    }

    public function prospect(Request $request, $id)
    {
        $selectedStatus = $request->input('status');
        $prospect = Prospect::find($id);
        $prospectsGroup = Prospect::where('groupId_prospect', $prospect->groupId_prospect)->get();

        // Set the initial $tiersChange value
        $tiersChange = 0;

        if ($selectedStatus === 'Fournisseur') {

            foreach ($prospectsGroup as $prospectItem) {
                $fournisseur = new Fournisseur();
                $fournisseur->nom_fournisseur = $prospectItem->nom_prospect;
                $fournisseur->email_fournisseur = $prospectItem->email_prospect;
                $fournisseur->tele_fournisseur = $prospectItem->tele_prospect;
                $fournisseur->ville_fournisseur = $prospectItem->ville_prospect;
                $fournisseur->nomSociete_fournisseur = $prospectItem->nomSociete_prospect;
                $fournisseur->GSM1_fournisseur = $prospectItem->GSM1_prospect;
                $fournisseur->GSM2_fournisseur = $prospectItem->GSM2_prospect;
                $fournisseur->lien_fournisseur = $prospectItem->lien_prospect;
                $fournisseur->user_id = $prospectItem->user_id;
                $fournisseur->remark = $prospectItem->remark;
                $fournisseur->groupId_fournisseur = $prospectItem->groupId_prospect;

                $fournisseur->save();

                if ($prospectItem->categories) {
                    foreach ($prospectItem->categories as $category) {
                        $fournisseur->categories()->attach($category->id);
                    }
                }
                $prospectItem->delete();

                // Increment the $tiersChange value (reflecting the number of moved prospects)
                $tiersChange++;
            }

            // Update the 'suppliersTracking' key with the new $tiersChange value
            $setting = Setting::where('key', 'suppliersTracking')->first();

            // If the setting does not exist, create it
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'suppliersTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }

            // Increment the value of 'addedToday' based on the tiersChange
            $setting->increment('addedToday', $tiersChange);
        } else if ($selectedStatus === 'Prosperts') {

            foreach ($prospectsGroup as $prospectItem) {
                $client = new Client();
                $client->nom_client = $prospectItem->nom_prospect;
                $client->email_client = $prospectItem->email_prospect;
                $client->tele_client = $prospectItem->tele_prospect;
                $client->ville_client = $prospectItem->ville_prospect;
                $client->nomSociete_client = $prospectItem->nomSociete_prospect;
                $client->GSM1_client = $prospectItem->GSM1_prospect;
                $client->GSM2_client = $prospectItem->GSM2_prospect;
                $client->lien_client = $prospectItem->lien_prospect;
                $client->user_id = $prospectItem->user_id;
                $client->remark = $prospectItem->remark;
                $client->groupId_client = $prospectItem->groupId_prospect;

                $client->save();

                if ($prospectItem->categories) {
                    foreach ($prospectItem->categories as $category) {
                        $client->categories()->attach($category->id);
                    }
                }
                $prospectItem->delete();

                // Increment the $tiersChange value
                $tiersChange++;
            }

            // Update the 'clientsTracking' key with the new $tiersChange value
            $setting = Setting::where('key', 'clientsTracking')->first();

            // If the setting does not exist, create it
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'clientsTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }

            // Increment the value of 'addedToday' based on the tiersChange
            $setting->increment('addedToday', $tiersChange);
        } else if ($selectedStatus === 'Fournisseur Client') {

            foreach ($prospectsGroup as $prospectItem) {
                $fc = new FournisseurClient();
                $fc->nom_fournisseurClient = $prospectItem->nom_prospect;
                $fc->email_fournisseurClient = $prospectItem->email_prospect;
                $fc->tele_fournisseurClient = $prospectItem->tele_prospect;
                $fc->ville_fournisseurClient = $prospectItem->ville_prospect;
                $fc->nomSociete_fournisseurClient = $prospectItem->nomSociete_prospect;
                $fc->GSM1_fournisseurClient = $prospectItem->GSM1_prospect;
                $fc->GSM2_fournisseurClient = $prospectItem->GSM2_prospect;
                $fc->lien_fournisseurClient = $prospectItem->lien_prospect;
                $fc->user_id = $prospectItem->user_id;
                $fc->remark = $prospectItem->remark;
                $fc->groupId_fournisseurClient = $prospectItem->groupId_prospect;

                $fc->save();

                if ($prospectItem->categories) {
                    foreach ($prospectItem->categories as $category) {
                        $fc->categories()->attach($category->id);
                    }
                }
                $prospectItem->delete();

                // Increment the $tiersChange value
                $tiersChange++;
            }

            // Update the 'FournisseurClientTracking' key with the new $tiersChange value
            $setting = Setting::where('key', 'FournisseurClientTracking')->first();

            // If the setting does not exist, create it
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'FournisseurClientTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }

            // Increment the value of 'addedToday' based on the tiersChange
            $setting->increment('addedToday', $tiersChange);
        }

        // Update the 'tiersTracking' key with the new $tiersChange value (if needed)
        $setting = Setting::where('key', 'tiersTracking')->first();
        if ($setting) {
            $setting->increment('deletedToday', $tiersChange);
        }
        ActivityLogController::logActivity("Transfert", "Clients","A transféré " . $tiersChange . " Clients à " . $selectedStatus);

        return redirect()->to(url()->previous());
    }
}
