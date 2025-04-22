<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;

class SousCategorieController extends Controller
{

    public function store(Request $request){
        $validator =Validator::make($request->all(),
        [
            'nom_produit' => ['required','max:255','unique:sous_categories,nom_produit'],
            'texte' => ['nullable', 'string'], // Rendre le champ optionnel
            'categorie_id' => ['required','integer','exists:categories,id']
        ],
        [
            'nom_produit.required' => 'Le produit est obligatoire!',
            'nom_produit.unique' => 'Le produit doit être unique!',
            'texte.required' => 'La description est obligatoire!',
            'categorie_id.required' => 'La catégorie est obligatoire!',
            'categorie_id.integer' => "L'identificateur doit être un entier valide!",
            'categorie_id.exists' => "Cette catégorie n'existe pas!"
        ]);

        if ($validator->fails()){
            return redirect()->back()
                   ->withInput()
                   ->with('modalType','default')
                   ->withErrors($validator);
        }

        $sousCategorie = new SousCategorie();
        $sousCategorie->nom_produit = $request->nom_produit;
        $sousCategorie->texte = $request->filled('texte') ? $request->texte : null;
        $sousCategorie->categorie_id = $request->categorie_id;
        $sousCategorie->save();

        alert()->success('Succès','Le produit'." ".$sousCategorie->nom_produit
        ." ".'a été enregistrée avec succès.');
        
        ActivityLogController::logActivity("Ajout", "SousCategorie", "A ajouté un produit " . $sousCategorie->nom_produit);
        return redirect()->to(url()->previous());

    }

    public function index(Request $request){
        $categories = Categorie::select('id','nom_categorie')->get();
        $sousCategorie = new SousCategorie();

        $perPage = $request->get('per_page',10);
        $getSousCategories = SousCategorie::with('categorie.fournisseurs')->paginate($perPage);
        return view('myApp.admin.links.sousCategories', compact('getSousCategories', 'categories', 'sousCategorie','perPage'));
    }

    public function sousCategoriesPdf()
{
       $products = SousCategorie::all();

        $options = new Options();
        $options->set('defaultFont', 'Courier'); // Définir une police
        $dompdf = new Dompdf($options);

        // Générer le contenu HTML
        $html = view('myApp/admin/pdf/sousCategories', compact('products'))->render();

        // Charger le contenu dans DomPDF
        $dompdf->loadHtml($html);

        // Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Générer le PDF
        $dompdf->render();

        // Télécharger automatiquement le fichier PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="sousCategories-list.pdf"');
    }


    public function destroy($id){
        $sousCategorie = SousCategorie::find($id);
        $sousCategorie->delete();
        
        ActivityLogController::logActivity("Suppression", "SousCategorie", "A supprimé " . $sousCategorie->nom_produit);
        return redirect()->to(url()->previous());
    }

    public function edit(Request $request){
        $sousCategorie = SousCategorie::find($request->id);
        return view('myApp.admin.links.sousCategories')->with('sousCategorie',$sousCategorie);
    }

    public function update(Request $request){
        $sousCategorie = SousCategorie::find($request->id);

        $rules = [
            'newNom_produit' => ['required','max:255'],
            'newTexte' => ['required','string',function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 10) {
                    $fail('La description ne doit pas dépasser 10 mots.');
                }
            }],
            'newCategorie_id' => ['required','integer','exists:categories,id']
        ];

        $messages = [
            'newNom_produit.required' => 'Le produit est obligatoire!',
            'newTexte.required' => 'La description est obligatoire!',
            'newCategorie_id.required' => 'La catégorie est obligatoire!',
            'newCategorie_id.integer' => "L'identificateur doit être un entier valide!",
            'newCategorie_id.exists' => "Cette catégorie n'existe pas!"

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                   ->withInput()
                   ->with('modalType','update')
                   ->withErrors($validator)
                   ->with('errors_displayed',true);
        }



        $sousCategorie->nom_produit = $request->newNom_produit;
        $sousCategorie->texte = $request->newTexte;
        $sousCategorie->categorie_id = $request->newCategorie_id;
        $sousCategorie->update();

        alert()->success('Succès', $sousCategorie->nom_produit . " a été mis à jour avec succès");
        
        ActivityLogController::logActivity("Modification", "SousCategorie", "A modifié " . $sousCategorie->nom_produit);

        return redirect()->to(url()->previous());

    }

    public function search (Request $request) {
        $search = $request->input('search');
        $products = SousCategorie :: with('categorie.fournisseurs')
                                    ->where('nom_produit','LIKE',"%{$search}%")
                                    ->orWhereHas('categorie', function ($query) use ($search) {
                                        $query->where('nom_categorie','LIKE',"%{$search}%");
                                    })
                                    ->get();

        return response()->json($products);

    }

}
