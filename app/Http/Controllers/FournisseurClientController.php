<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\FournisseurClient;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Prospect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Setting;

class FournisseurClientController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'nom_fournisseurClient' => ['nullable', 'max:50', 'string'],
            'email_fournisseurClient' => ['nullable','email', 'string', 'max:266', 'unique:fournisseur_clients,email_fournisseurClient'],
            'lien_fournisseurClient' => ['nullable','url', 'string', 'max:266', 'unique:fournisseur_clients,lien_fournisseurClient'],
            'tele_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseur_clients,tele_fournisseurClient'],
            'ville_fournisseurClient' => ['required', 'max:60', 'string'],
            'nomSociete_fournisseurClient' => ['nullable', 'max:200', 'unique:fournisseur_clients,nomSociete_fournisseurClient'],
            'GSM1_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseur_clients,GSM1_fournisseurClient'],
            'GSM2_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/', 'unique:fournisseur_clients,GSM2_fournisseurClient'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        $messages = [
            // 'nom_fournisseurClient.required' => 'Le nom est obligatoire!',
            'nom_fournisseurClient.string' => 'Le nom doit être en chaine de caractère!',
            // 'email_fournisseurClient.required' => "L'émail est obligatoire!",
            'email_fournisseurClient.string' => "L'émail doit être en chaine de caractère!",
            'email_fournisseurClient.unique' => "L'émail doit être unique!",
            'lien_fournisseurClient.string' => "Lien doit être en chaine de caractère!",
            'lien_fournisseurClient.unique' => "Lien doit être unique!",
            'ville_fournisseurClient.required' => "La ville est obligatoire!",
            'ville_fournisseurClient.string' => 'La ville doit être en chaine de caractère!',
            // 'tele_fournisseurClient.required' => 'Le contact est obligatoire!',
            'tele_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
            'tele_fournisseurClient.unique' => 'Le contact doit être unique!',
            'GSM1_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
            'GSM1_fournisseurClient.unique' => 'Le contact de la societe doit être unique!',
            'GSM2_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
            'GSM2_fournisseurClient.unique' => 'Le contact de la societe doit être unique!',
            'nomSociete_fournisseurClient.unique' => "Le nom de la société doit être unique!",
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

        $fournisseurClient = new FournisseurClient();
        $fournisseurClient->nom_fournisseurClient = $request->nom_fournisseurClient ?? '';
        $fournisseurClient->ville_fournisseurClient = $request->ville_fournisseurClient;
        $fournisseurClient->tele_fournisseurClient = $request->tele_fournisseurClient ?? '';
        $fournisseurClient->GSM1_fournisseurClient = $request->GSM1_fournisseurClient ?? '';
        $fournisseurClient->GSM2_fournisseurClient = $request->GSM2_fournisseurClient ?? '';
        $fournisseurClient->lien_fournisseurClient = $request->lien_fournisseurClient ?? '';
        $fournisseurClient->email_fournisseurClient = $request->email_fournisseurClient ?? '';
        $fournisseurClient->nomSociete_fournisseurClient = $request->nomSociete_fournisseurClient ?? '';

        $fournisseurClient->groupId_fournisseurClient = Str::uuid();
        $fournisseurClient->save();

        ActivityLogController::logActivity("Ajout", "Fournisseur-Client",  " A ajouté " . $fournisseurClient->nom_fournisseurClient );
        // Attach to the category
        $categorie = Categorie::find($request->categorie_id);
        $categorie->clientFournisseurs()->attach($fournisseurClient->id);

        // Update the 'addedToday' in the settings table
        $setting = Setting::where('key', 'FournisseurClientTracking')->first();

        // If settings are not found, initialize them
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'FournisseurClientTracking',
                'value' => 0,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Increment the 'addedToday' counter
        $setting->increment('addedToday');

        alert()->success('succès', $fournisseurClient->nom_fournisseurClient . " " . 'a été enregistrée avec succès.');
        return redirect()->to(url()->previous());
    }

    public function updateUserFC(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);


        $fc = FournisseurClient::findOrFail($id);

        $fcs = FournisseurClient::where('groupId_fournisseurClient', $fc->groupId_fournisseurClient)->get();

        foreach ($fcs as $fc) {
            $fc->user_id = $request->user_id ?? $fc->user_id;
            $fc->save();
        }

        ActivityLogController::logActivity("Contacté par", "Fournisseur-Client","A modifié qui contacté  " . $fc->nom_fournisseurClient);

        return redirect()->back();
    }

    public function updateRemarkFC(Request $request, $id)
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

        $fc = FournisseurClient::findOrFail($id);

        $fcs = FournisseurClient::where('groupId_fournisseurClient', $fc->groupId_fournisseurClient)->get();

        foreach ($fcs as $fc) {
            $fc->remark = $request->remark;
            $fc->save();
        }

        ActivityLogController::logActivity("Remarque", "Fournisseur-Client","A ajouté une remarque a  " . $fc->nom_fournisseurClient);
        return redirect()->back();
    }
    public function index(Request $request)
    {
        if (!auth()->user()->permission || !auth()->user()->permission->can_see_fournisseurs_clients) {
            return view('errors.permission_denied');
        }
        
        $perPage = $request->get('per_page', 10);
        $fournisseurClients = FournisseurClient::with('categories', 'categorieClientFournisseurs.categorie', 'utilisateur')->paginate($perPage);
        $categories = Categorie::with('sousCategories')->get();
        foreach ($fournisseurClients as $fc) {
            $fc->allCategories = $fc->allCategories();
        }

        $select = ['Fournisseur', 'Prosperts', 'Clients'];

        return view('myApp.admin.links.clientFournisseur', compact('categories', 'fournisseurClients', 'select', 'perPage'));
    }

    public function fournisseurClientsPdf()
    {

        $fcs = FournisseurClient::with('categorieClientFournisseurs.categorie')->get();

        $options = new Options();
        $options->set('defaultFont', 'Courier'); // Définir une police
        $dompdf = new Dompdf($options);

        // Générer le contenu HTML
        $html = view('myApp/admin/pdf/fournisseurClients', compact('fcs'))->render();

        // Charger le contenu dans DomPDF
        $dompdf->loadHtml($html);

        // Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Générer le PDF
        $dompdf->render();

        // Télécharger automatiquement le fichier PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="fournisseurClients-list.pdf"');
    }




    public function destroy($id)
    {
        $fournisseurClient = FournisseurClient::find($id);

        if ($fournisseurClient) {
            $fournisseurClient->delete();

            // Update the 'deletedToday' in the settings table
            $setting = Setting::where('key', 'FournisseurClientTracking')->first();

            // If settings are not found, initialize them
            if (!$setting) {
                $setting = Setting::create([
                    'key' => 'FournisseurClientTracking',
                    'value' => 0,
                    'addedToday' => 0,
                    'deletedToday' => 0,
                ]);
            }

            // Increment the 'deletedToday' counter
            $setting->increment('deletedToday');
        }

        ActivityLogController::logActivity("Suppression", "Fournisseur-Client",  " A supprimé  " . $fournisseurClient->nom_fournisseurClient );

        return redirect()->to(url()->previous());
    }


    public function search(Request $request)
    {
        $select = ['Fournisseur', 'Prosperts', 'Clients'];
        $search = $request->input('search');
        $fc = FournisseurClient::with(['categories.sousCategories', 'utilisateur'])
            ->where('nom_fournisseurClient', 'LIKE', "%{$search}%")
            ->orWhere('nomSociete_fournisseurClient', 'LIKE', "%{$search}%")
            ->orWhere('nom_fournisseurClient', 'LIKE', "%{$search}%")

            ->get();
        return response()->json([
            'fcs' => $fc,
            'selectOptions' => $select
        ]);
    }




    public function update(Request $request)
    {

        $fc = FournisseurClient::find((int)$request->id);

        $rules = [
            'newNom_fournisseurClient' => ['nullable', 'max:50', 'string'],
            'newEmail_fournisseurClient' => ['nullable','string', 'max:266'],
            'newLien_fournisseurClient' => ['nullable','string', 'max:266'],
            'newTele_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newVille_fournisseurClient' => ['required', 'max:60', 'string'],
            'newNomSociete_fournisseurClient' => ['nullable', 'max:200'],
            'newGSM1_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newGSM2_fournisseurClient' => ['nullable', 'regex:/^\+?[0-9]{9,15}$/'],
            'newCategorie_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        $messages = [
            // 'newNom_fournisseurClient.required' => 'Le nom est obligatoire!',
            'newNom_fournisseurClient.string' => 'Le nom doit être en chaine de caractère!',
            // 'newEmail_fournisseurClient.required' => "L'émail est obligatoire!",
            'newEmail_fournisseurClient.string' => "L'émail doit être en chaine de caractère!",
            'newLien_fournisseurClient.string' => "L'émail doit être en chaine de caractère!",
            'newVille_fournisseurClient.required' => "La ville est obligatoire!",
            'newVille_fournisseurClient.string' => 'La ville doit être en chaine de caractère!',
            // 'newTele_fournisseurClient.required' => 'Le contact est obligatoire!',
            'newTele_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
            'newGSM1_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
            'newGSM2_fournisseurClient.regex' => 'Le numéro de téléphone doit être valide!',
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

        $nomSociety = $request->newNomSociete_fournisseurClient ?? '';
        $GSM1 = $request->newGSM1_fournisseurClient ?? '';
        $GSM2 = $request->newGSM2_fournisseurClient ?? '';
        $lien = $request->newLien_fournisseurClient ?? '';
        $email = $request->newEmail_fournisseurClient ?? '';
        $name = $request->newNom_fournisseurClient ?? '';
        $tele = $request->newTele_fournisseurClient ?? '';


        $newCategorieId = $request->newCategorie_id;
        $existingFC = FournisseurClient::where('nom_fournisseurClient', $request->newNom_fournisseurClient)
            ->where('email_fournisseurClient', $email)
            ->where('tele_fournisseurClient', $request->newTele_fournisseurClient)
            ->where('ville_fournisseurClient', $request->newVille_fournisseurClient)
            ->where('nomSociete_fournisseurClient', $nomSociety)
            ->where('GSM1_fournisseurClient', $GSM1)
            ->where('GSM2_fournisseurClient', $GSM2)
            ->where('lien_fournisseurClient', $lien)
            ->whereHas('categories', function ($query) use ($newCategorieId) {
                $query->where('categories.id', $newCategorieId);
            })
            ->first();

        if ($existingFC) {
            alert()->error('Erreur', 'Une version avec les mêmes informations existe déjà. Veuillez modifier au moins un champ.');
            return redirect()->back()->withInput();
        }

        if ($newCategorieId && !$this->hasOtherChanges($fc, $request)) {
            $newFC = $fc->replicate();
            $newFC->groupId_fournisseurClient = $fc->groupId_fournisseurClient;
            $newFC->version_fournisseurClient = $fc->version_fournisseurClient + 1;
            $newFC->save();

            $newFC->categories()->sync([$newCategorieId]);

            alert()->success('Succès', "La catégorie a été modifiée et une nouvelle version a été créée.");
            return redirect()->back();
        }

        $fc->nom_fournisseurClient = $request->newNom_fournisseurClient ?? '';
        $fc->email_fournisseurClient = $request->newEmail_fournisseurClient ?? '';
        $fc->tele_fournisseurClient = $request->newTele_fournisseurClient ?? '';
        $fc->ville_fournisseurClient = $request->newVille_fournisseurClient;
        $fc->GSM1_fournisseurClient = $request->newGSM1_fournisseurClient ?? '';
        $fc->GSM2_fournisseurClient = $request->newGSM2_fournisseurClient ?? '';
        $fc->lien_fournisseurClient = $request->newLien_fournisseurClient ?? '';
        $fc->nomSociete_fournisseurClient = $request->newNomSociete_fournisseurClient ?? '';

        if ($fc->save()) {
            alert()->success('Succès', 'Le fournisseur client a été mis à jour avec succès.');
        }

        $FCSimilaires =  FournisseurClient::where('groupId_fournisseurClient', $fc->groupId_fournisseurClient)
            ->where('id', '!=', $fc->id)
            ->get();

        foreach ($FCSimilaires as $similarFC) {
            $similarFC->nom_fournisseurClient = $request->newNom_fournisseurClient ?? '';
            $similarFC->email_fournisseurClient = $request->newEmail_fournisseurClient ?? '';
            $similarFC->tele_fournisseurClient = $request->newTele_fournisseurClient ?? '';
            $similarFC->ville_fournisseurClient = $request->newVille_fournisseurClient;
            $similarFC->GSM1_fournisseurClient = $request->newGSM1_fournisseurClient ?? '';
            $similarFC->GSM2_fournisseurClient = $request->newGSM2_fournisseurClient ?? '';
            $similarFC->lien_fournisseurClient = $request->newLien_fournisseurClient ?? '';
            $similarFC->nomSociete_fournisseurClient = $request->newNomSociete_fournisseurClient ?? '';
            if ($similarFC->save()) {
                alert()->success('Succès', 'Le fournisseur client a été mis à jour avec succès.');
            }
        }


        ActivityLogController::logActivity("Modification", "Fournisseur-Client",  " A modifié " . $fc->nom_fournisseurClient );

        return redirect()->back();
    }

    private function hasOtherChanges($fc, $request)
    {

        return $fc->nom_fournisseurClient !== ($request->newNom_fournisseurClient ?? '') ||
            $fc->email_fournisseurClient !== ($request->newEmail_fournisseurClient ?? '') ||
            $fc->tele_fournisseurClient !== ($request->newTele_fournisseurClient ?? '') ||
            $fc->ville_fournisseurClient !== $request->newVille_fournisseurClient ||
            $fc->nomSociete_fournisseurClient !== ($request->newNomSociete_fournisseurClient ?? '') ||
            $fc->GSM1_fournisseurClient !== ($request->newGSM1_fournisseurClient ?? '') ||
            $fc->GSM2_fournisseurClient !== ($request->newGSM2_fournisseurClient ?? '')||
            $fc->lien_fournisseurClient !== ($request->newLien_fournisseurClient ?? '');
    }

    public function fournisseurClient(Request $request, $id)
{
    $selectedStatus = $request->input('status');
    $fc = FournisseurClient::find($id);

    $fcsGroup = FournisseurClient::where('groupId_fournisseurClient', $fc->groupId_fournisseurClient)->get();

    // Initialize the number of records processed
    $recordsProcessed = 0;

    if ($selectedStatus === 'Fournisseur') {
        foreach ($fcsGroup as $fcItem) {
            $fournisseur = new Fournisseur();
            $fournisseur->nom_fournisseur = $fcItem->nom_fournisseurClient;
            $fournisseur->email_fournisseur = $fcItem->email_fournisseurClient;
            $fournisseur->tele_fournisseur = $fcItem->tele_fournisseurClient;
            $fournisseur->ville_fournisseur = $fcItem->ville_fournisseurClient;
            $fournisseur->nomSociete_fournisseur = $fcItem->nomSociete_fournisseurClient;
            $fournisseur->GSM1_fournisseur = $fcItem->GSM1_fournisseurClient;
            $fournisseur->GSM2_fournisseur = $fcItem->GSM2_fournisseurClient;
            $fournisseur->lien_fournisseur = $fcItem->lien_fournisseurClient;
            $fournisseur->user_id = $fcItem->user_id;
            $fournisseur->remark = $fcItem->remark;
            $fournisseur->groupId_fournisseur = $fcItem->groupId_fournisseurClient;
            $fournisseur->save();

            if ($fcItem->categories) {
                foreach ($fcItem->categories as $category) {
                    $fournisseur->categories()->attach($category->id);
                }
            }

            $fcItem->delete();
            $recordsProcessed++;
        }

        // Update the settings for suppliersTracking
        $setting = Setting::where('key', 'suppliersTracking')->first();
        if ($setting) {
            $setting->addedToday += $recordsProcessed;
            $setting->save();
        }

    } else if ($selectedStatus === 'Prosperts') {
        foreach ($fcsGroup as $fcItem) {
            $client = new Client();
            $client->nom_client = $fcItem->nom_fournisseurClient;
            $client->email_client = $fcItem->email_fournisseurClient;
            $client->tele_client = $fcItem->tele_fournisseurClient;
            $client->ville_client = $fcItem->ville_fournisseurClient;
            $client->GSM1_client = $fcItem->GSM1_fournisseurClient;
            $client->GSM2_client = $fcItem->GSM2_fournisseurClient;
            $client->lien_client = $fcItem->lien_fournisseurClient;
            $client->nomSociete_client = $fcItem->nomSociete_fournisseurClient;
            $client->user_id = $fcItem->user_id;
            $client->remark = $fcItem->remark;
            $client->groupId_client = $fcItem->groupId_fournisseurClient;
            $client->save();

            if ($fcItem->categories) {
                foreach ($fcItem->categories as $category) {
                    $client->categories()->attach($category->id);
                }
            }

            $fcItem->delete();
            $recordsProcessed++;
        }

        // Update the settings for clientsTracking
        $setting = Setting::where('key', 'clientsTracking')->first();
        if ($setting) {
            $setting->addedToday += $recordsProcessed;
            $setting->save();
        }

    } else if ($selectedStatus === 'Clients') {
        foreach ($fcsGroup as $fcItem) {
            $prospect = new Prospect();
            $prospect->nom_prospect = $fcItem->nom_fournisseurClient;
            $prospect->email_prospect = $fcItem->email_fournisseurClient;
            $prospect->tele_prospect = $fcItem->tele_fournisseurClient;
            $prospect->ville_prospect = $fcItem->ville_fournisseurClient;
            $prospect->nomSociete_prospect = $fcItem->nomSociete_fournisseurClient;
            $prospect->GSM1_prospect = $fcItem->GSM1_fournisseurClient;
            $prospect->GSM2_prospect = $fcItem->GSM2_fournisseurClient;
            $prospect->lien_prospect = $fcItem->lien_fournisseurClient;
            $prospect->user_id = $fcItem->user_id;
            $prospect->remark = $fcItem->remark;
            $prospect->groupId_prospect = $fcItem->groupId_fournisseurClient;
            $prospect->save();

            if ($fcItem->categories) {
                foreach ($fcItem->categories as $category) {
                    $prospect->categories()->attach($category->id);
                }
            }

            $fcItem->delete();
            $recordsProcessed++;
        }

        // Update the settings for tiersTracking
        $setting = Setting::where('key', 'tiersTracking')->first();
        if ($setting) {
            $setting->addedToday += $recordsProcessed;
            $setting->save();
        }
    }

    // Update the deletedToday field for FournisseurClientTracking key
    $setting = Setting::where('key', 'FournisseurClientTracking')->first();
    if ($setting) {
        $setting->deletedToday += $recordsProcessed;
        $setting->save();
    }
    ActivityLogController::logActivity("Transfert", "Fournisseur-Client","A transféré " . $recordsProcessed . " fournisseurs-clients à " . $selectedStatus);

    return redirect()->to(url()->previous());
}

}
