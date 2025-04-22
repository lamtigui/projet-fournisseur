<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;

class CategorieController extends Controller
{
    public function store(Request $request)
{
    $rules = [
        'nom_categorie' => ['required', 'string', 'max:255'],
        'fournisseur_id' => ['nullable', 'integer', 'exists:fournisseurs,id'],
    ];

    $messages = [
        'nom_categorie.required' => 'La catégorie est obligatoire!',
        'fournisseur_id.integer' => "L'identificateur doit être un entier!",
        'fournisseur_id.exists' => "Ce fournisseur n'existe pas!",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()
            ->withInput()
            ->with('modalType', 'default')
            ->withErrors($validator);
    }

    $categorie = new Categorie();
    $categorie->nom_categorie = $request->nom_categorie;
    $categorie->save();

    if ($request->filled('fournisseur_id')) {
        $fournisseur = Fournisseur::find($request->fournisseur_id);

        if ($fournisseur) {
            $fournisseur->categories()->attach($categorie->id);
        }
    }

    ActivityLogController::logActivity("Ajout", "Categorie", "A ajouté  " . $categorie->nom_categorie);

    alert()->success('Succès', 'La catégorie'." ".$categorie->nom_categorie." ".'a été enregistrée avec succès.');
    return redirect()->to(url()->previous());
}


    public function index(Request $request){

        $fournisseurs = Fournisseur::select('id', 'nom_fournisseur')->get();

        $perPage = $request->get('per_page',10);
        $categories = Categorie::with('fournisseurs')->paginate($perPage);



        return view('myApp.admin.links.categories', compact('categories', 'fournisseurs','perPage'));
    }

    public function categoriesPdf(Request $request)
{

        $categories = Categorie::all();

        $options = new Options();
        $options->set('defaultFont', 'Courier'); // Définir une police
        $dompdf = new Dompdf($options);

        // Générer le contenu HTML
        $html = view('myApp/admin/pdf/categories', compact('categories'))->render();

        // Charger le contenu dans DomPDF
        $dompdf->loadHtml($html);

        // Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Générer le PDF
        $dompdf->render();

        // Télécharger automatiquement le fichier PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="categories-list.pdf"');
    }


    public function destroy($id){
        $categorie=Categorie::find($id);
        $categorie->delete();
        ActivityLogController::logActivity("Suppression", "Categorie", "A supprimé " . $categorie->nom_categorie);
        return redirect()->to(url()->previous());
    }

    public function edit(Request $request){
        $categorie = Categorie::find($request->id);
        return view('myApp.admin.links.categories')->with('categorie',$categorie);
    }

    public function update(Request $request){

        $categorie = Categorie::find($request->id);
        $rules = [
            'newNom_categorie' => ['required','string','max:255'],
        ];
        $messages = [
            'newNom_categorie.required' => 'La catégorie est obligatoire!',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect()->back()
                   ->withInput()
                   ->with('modalType','update')
                   ->withErrors($validator)
                   ->with('errors_displayed',true);
        }

        $categorie->nom_categorie = $request->newNom_categorie;
        $categorie->update();
        alert()->success('Succès', $categorie->nom_categorie . " a été mis à jour avec succès");


        ActivityLogController::logActivity("Modification", "Categorie", "A modifié " . $categorie->nom_categorie);

        return redirect()->to(url()->previous());

    }

    public function search (Request $request) {

        $search = $request->input('search');

        $category = Categorie :: where('nom_categorie','LIKE',"%{$search}%")->with(['fournisseurs','sousCategories'])->get();

        return response()->json($category);

    }
    public function getSousCategories($categorieId)
{
    $sousCategories = Categorie::find($categorieId)->sousCategories()->get();

    return response()->json($sousCategories);
}

}
