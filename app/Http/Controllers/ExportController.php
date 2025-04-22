<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Client;
use App\Models\Prospect;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\SousCategorie;
use App\Models\FournisseurClient;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function allDataPdf()
    {
        // Récupération des données de toutes les tables
        $clients = Client::with('categorieClients.categorie')->get();
        $prospects = Prospect::all();
        $fournisseurs = Fournisseur::all();
        $fcs = FournisseurClient::all();

        // Configuration de DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        // Chargement de la vue avec les données
        $html = view('myApp/admin/pdf/all_data', compact('clients', 'prospects', 'fournisseurs', 'fcs'))->render();
        $dompdf->loadHtml($html);

        // Configuration du format de la page
        $dompdf->setPaper('A4', 'portrait');

        // Génération du PDF
        $dompdf->render();

        // Téléchargement du fichier PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="all_data.pdf"');
    }
    public function exportUsersExcel()
    {
        $users = User::all(); // Récupérer tous les utilisateurs

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Ajouter les en-têtes
        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Contact');
        $sheet->setCellValue('D1', 'Adresse');
        $sheet->setCellValue('E1', 'Role');

        // Remplir les données des utilisateurs
        $row = 2; // À partir de la deuxième ligne
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->name);
            $sheet->setCellValue('B' . $row, $user->email);
            $sheet->setCellValue('C' . $row, $user->contact);
            $sheet->setCellValue('D' . $row, $user->adresse);
            $sheet->setCellValue('E' . $row, $user->role);
            $row++;
        }

        // Créer un écrivain Xlsx et forcer le téléchargement
        $writer = new Xlsx($spreadsheet);
        $fileName = 'users_export.xlsx';

        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
    public function exportCategoriesExcel()
    {
        $categories = Categorie::all(); // Récupérer toutes les catégories

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter les en-têtes
        $sheet->setCellValue('A1', 'Nom de la Catégorie');

        // Remplir les données des catégories
        $row = 2; // À partir de la deuxième ligne
        foreach ($categories as $categorie) {
            $sheet->setCellValue('A' . $row, $categorie->nom_categorie);
            $row++;
        }

        // Créer un écrivain Xlsx et forcer le téléchargement
        $writer = new Xlsx($spreadsheet);
        $fileName = 'categories_export.xlsx';

        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function exportSousCategoriesExcel()
    {
        $sousCategories = SousCategorie::with('categorie')->get(); // Récupérer toutes les sous-catégories avec leur catégorie associée

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter les en-têtes
        $sheet->setCellValue('A1', 'Nom du Produit');
        $sheet->setCellValue('B1', 'Nom de la Catégorie');

        // Remplir les données des sous-catégories
        $row = 2; // À partir de la deuxième ligne
        foreach ($sousCategories as $sousCategorie) {
            $sheet->setCellValue('A' . $row, $sousCategorie->nom_produit); // Nom du produit
            $sheet->setCellValue('B' . $row, $sousCategorie->categorie->nom_categorie ?? 'Non définie'); // Nom de la catégorie
            $row++;
        }

        // Créer un écrivain Xlsx et forcer le téléchargement
        $writer = new Xlsx($spreadsheet);
        $fileName = 'sous_categories_export.xlsx';

        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
     // Méthode pour exporter les données en Excel
     public function exportclients()
     {
         $clients = Client::all(); // Récupère tous les clients
 
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         // Ajouter les en-têtes
         $sheet->setCellValue('A1', 'Nom de la société');
         $sheet->setCellValue('B1', 'GSM1 de la société');
         $sheet->setCellValue('C1', 'GSM2 de la société');
         $sheet->setCellValue('D1', 'Personne à contacter');
         $sheet->setCellValue('E1', 'Numero de telephone');
         $sheet->setCellValue('F1', 'Email');
         $sheet->setCellValue('G1', 'Ville');
         $sheet->setCellValue('H1', 'Catégorie');
         $sheet->setCellValue('I1', 'Contacté Par');
 
         // Remplir les données
         $row = 2;
         foreach ($clients as $client) {
             $sheet->setCellValue('A' . $row, $client->nomSociete_client ?? 'Particulier');
             $sheet->setCellValue('B' . $row, $client->GSM1_client ?? 'Non disponible');
             $sheet->setCellValue('C' . $row, $client->GSM2_client ?? 'Non disponible');
             $sheet->setCellValue('D' . $row, $client->nom_client ?? 'Non disponible');
             $sheet->setCellValue('E' . $row, $client->tele_client ?? 'Non disponible');
             $sheet->setCellValue('F' . $row, $client->email_client ?? 'Non disponible');
             $sheet->setCellValue('G' . $row, $client->ville_client);
             $sheet->setCellValue('H' . $row, $client->categorieClients->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheet->setCellValue('I' . $row, $client->utilisateur->name ?? 'Personne');
             $row++;
         }
 
         // Créer un écrivain Xlsx et forcer le téléchargement
         $writer = new Xlsx($spreadsheet);
         $fileName = 'clients_export.xlsx';
 
         return response()->stream(
             function() use ($writer) {
                 $writer->save('php://output');
             },
             200,
             [
                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                 'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
             ]
         );
     }
     public function exportprospects()
     {
         $prospects = Prospect::all(); // Récupère tous les prospects
 
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         // Ajouter les en-têtes
         $sheet->setCellValue('A1', 'Nom de la société');
         $sheet->setCellValue('B1', 'GSM1 de la société');
         $sheet->setCellValue('C1', 'GSM2 de la société');
         $sheet->setCellValue('D1', 'Personne à contacter');
         $sheet->setCellValue('E1', 'Numero de telephone');
         $sheet->setCellValue('F1', 'Email');
         $sheet->setCellValue('G1', 'Ville');
         $sheet->setCellValue('H1', 'Catégorie');
         $sheet->setCellValue('I1', 'Contacté Par');
 
         // Remplir les données
         $row = 2;
         foreach ($prospects as $prospect) {
             $sheet->setCellValue('A' . $row, $prospect->nomSociete_prospect ?? 'Particulier');
             $sheet->setCellValue('B' . $row, $prospect->GSM1_prospect ?? 'Non disponible');
             $sheet->setCellValue('C' . $row, $prospect->GSM2_prospect ?? 'Non disponible');
             $sheet->setCellValue('D' . $row, $prospect->nom_prospect ?? 'Non disponible');
             $sheet->setCellValue('E' . $row, $prospect->tele_prospect ?? 'Non disponible');
             $sheet->setCellValue('F' . $row, $prospect->email_prospect ?? 'Non disponible');
             $sheet->setCellValue('G' . $row, $prospect->ville_prospect);
             $sheet->setCellValue('H' . $row, $prospect->categorieProspects->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheet->setCellValue('I' . $row, $prospect->utilisateur->name ?? 'Personne');
             $row++;
         }
 
         // Créer un écrivain Xlsx et forcer le téléchargement
         $writer = new Xlsx($spreadsheet);
         $fileName = 'prospects_export.xlsx';
 
         return response()->stream(
             function() use ($writer) {
                 $writer->save('php://output');
             },
             200,
             [
                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                 'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
             ]
         );
     }
     public function exportfournisseurs()
     {
         $fournisseurs = Fournisseur::all(); // Récupère tous les fournisseurs
 
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         // Ajouter les en-têtes
         $sheet->setCellValue('A1', 'Nom de la société');
         $sheet->setCellValue('B1', 'GSM1 de la société');
         $sheet->setCellValue('C1', 'GSM2 de la société');
         $sheet->setCellValue('D1', 'Personne à contacter');
         $sheet->setCellValue('E1', 'Numero de telephone');
         $sheet->setCellValue('F1', 'Email');
         $sheet->setCellValue('G1', 'Ville');
         $sheet->setCellValue('H1', 'Catégorie');
         $sheet->setCellValue('I1', 'Contacté Par');
 
         // Remplir les données
         $row = 2;
         foreach ($fournisseurs as $fournisseur) {
             $sheet->setCellValue('A' . $row, $fournisseur->nomSociete_fournisseur ?? 'Particulier');
             $sheet->setCellValue('B' . $row, $fournisseur->GSM1_fournisseur ?? 'Non disponible');
             $sheet->setCellValue('C' . $row, $fournisseur->GSM2_fournisseur ?? 'Non disponible');
             $sheet->setCellValue('D' . $row, $fournisseur->nom_fournisseur ?? 'Non disponible');
             $sheet->setCellValue('E' . $row, $fournisseur->tele_fournisseur ?? 'Non disponible');
             $sheet->setCellValue('F' . $row, $fournisseur->email_fournisseur ?? 'Non disponible');
             $sheet->setCellValue('G' . $row, $fournisseur->ville_fournisseur);
             $sheet->setCellValue('H' . $row, $fournisseur->categorieFournisseur->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheet->setCellValue('I' . $row, $fournisseur->utilisateur->name ?? 'Personne');
             $row++;
         }
 
         // Créer un écrivain Xlsx et forcer le téléchargement
         $writer = new Xlsx($spreadsheet);
         $fileName = 'fournisseurs_export.xlsx';
 
         return response()->stream(
             function() use ($writer) {
                 $writer->save('php://output');
             },
             200,
             [
                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                 'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
             ]
         );
     }
     public function exportfournisseurClients()
     {
         $fournisseurClients = FournisseurClient::all(); // Récupère tous les fournisseurClients
 
         $spreadsheet = new Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
 
         // Ajouter les en-têtes
         $sheet->setCellValue('A1', 'Nom de la société');
         $sheet->setCellValue('B1', 'GSM1 de la société');
         $sheet->setCellValue('C1', 'GSM2 de la société');
         $sheet->setCellValue('D1', 'Personne à contacter');
         $sheet->setCellValue('E1', 'Numero de telephone');
         $sheet->setCellValue('F1', 'Email');
         $sheet->setCellValue('G1', 'Ville');
         $sheet->setCellValue('H1', 'Catégorie');
         $sheet->setCellValue('I1', 'Contacté Par');
 
         // Remplir les données
         $row = 2;
         foreach ($fournisseurClients as $fournisseurClient) {
             $sheet->setCellValue('A' . $row, $fournisseurClient->nomSociete_fournisseurClient ?? 'Particulier');
             $sheet->setCellValue('B' . $row, $fournisseurClient->GSM1_fournisseurClient ?? 'Non disponible');
             $sheet->setCellValue('C' . $row, $fournisseurClient->GSM2_fournisseurClient ?? 'Non disponible');
             $sheet->setCellValue('D' . $row, $fournisseurClient->nom_fournisseurClient ?? 'Non disponible');
             $sheet->setCellValue('E' . $row, $fournisseurClient->tele_fournisseurClient ?? 'Non disponible');
             $sheet->setCellValue('F' . $row, $fournisseurClient->email_fournisseurClient ?? 'Non disponible');
             $sheet->setCellValue('G' . $row, $fournisseurClient->ville_fournisseurClient);
             $sheet->setCellValue('H' . $row, $fournisseurClient->categorieClientFournisseurs->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheet->setCellValue('I' . $row, $fournisseurClient->utilisateur->name ?? 'Personne');
             $row++;
         }
 
         // Créer un écrivain Xlsx et forcer le téléchargement
         $writer = new Xlsx($spreadsheet);
         $fileName = 'fournisseurClients_export.xlsx';
 
         return response()->stream(
             function() use ($writer) {
                 $writer->save('php://output');
             },
             200,
             [
                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                 'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
             ]
         );
     }
     public function exportAllDataExcel()
    {
        // Récupérer toutes les données de chaque table
        $clients = Client::all();
        $prospects = Prospect::all();
        $fournisseurs = Fournisseur::all();
        $fournisseurClients = FournisseurClient::all();

        // Créer un nouveau classeur Excel
        $spreadsheet = new Spreadsheet();

        // ============================
        // Feuille pour les Clients
        // ============================
        $spreadsheet->createSheet();
        $sheetClients = $spreadsheet->getSheet(0);
        $sheetClients->setTitle('Clients');

        // Ajouter les en-têtes pour les clients
        $sheetClients->setCellValue('A1', 'Nom de la société');
        $sheetClients->setCellValue('B1', 'GSM1');
        $sheetClients->setCellValue('C1', 'GSM2');
        $sheetClients->setCellValue('D1', 'Nom');
        $sheetClients->setCellValue('E1', 'Téléphone');
        $sheetClients->setCellValue('F1', 'Email');
        $sheetClients->setCellValue('G1', 'Ville');
        $sheetClients->setCellValue('H1', 'Catégorie');
        $sheetClients->setCellValue('I1', 'Utilisateur');

        // Remplir les données des clients
        $row = 2;
        foreach ($clients as $client) {
             $sheetClients->setCellValue('A' . $row, $client->nomSociete_client ?? 'Particulier');
             $sheetClients->setCellValue('B' . $row, $client->GSM1_client ?? 'Non disponible');
             $sheetClients->setCellValue('C' . $row, $client->GSM2_client ?? 'Non disponible');
             $sheetClients->setCellValue('D' . $row, $client->nom_client ?? 'Non disponible');
             $sheetClients->setCellValue('E' . $row, $client->tele_client ?? 'Non disponible');
             $sheetClients->setCellValue('F' . $row, $client->email_client ?? 'Non disponible');
             $sheetClients->setCellValue('G' . $row, $client->ville_client);
             $sheetClients->setCellValue('H' . $row, $client->categorieClients->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheetClients->setCellValue('I' . $row, $client->utilisateur->name ?? 'Personne');
             $row++;
         }

        // ============================
        // Feuille pour les Prospects
        // ============================
        $spreadsheet->createSheet();
        $sheetProspects = $spreadsheet->getSheet(1);
        $sheetProspects->setTitle('Prospects');

        // Ajouter les en-têtes pour les prospects
        $sheetProspects->setCellValue('A1', 'Nom de la société');
        $sheetProspects->setCellValue('B1', 'GSM1');
        $sheetProspects->setCellValue('C1', 'GSM2');
        $sheetProspects->setCellValue('D1', 'Nom');
        $sheetProspects->setCellValue('E1', 'Téléphone');
        $sheetProspects->setCellValue('F1', 'Email');
        $sheetProspects->setCellValue('G1', 'Ville');
        $sheetProspects->setCellValue('H1', 'Catégorie');
        $sheetProspects->setCellValue('I1', 'Utilisateur');

        // Remplir les données des prospects
        $row = 2;
        foreach ($prospects as $prospect) {
             $sheetProspects->setCellValue('A' . $row, $prospect->nomSociete_prospect ?? 'Particulier');
             $sheetProspects->setCellValue('B' . $row, $prospect->GSM1_prospect ?? 'Non disponible');
             $sheetProspects->setCellValue('C' . $row, $prospect->GSM2_prospect ?? 'Non disponible');
             $sheetProspects->setCellValue('D' . $row, $prospect->nom_prospect ?? 'Non disponible');
             $sheetProspects->setCellValue('E' . $row, $prospect->tele_prospect ?? 'Non disponible');
             $sheetProspects->setCellValue('F' . $row, $prospect->email_prospect ?? 'Non disponible');
             $sheetProspects->setCellValue('G' . $row, $prospect->ville_prospect);
             $sheetProspects->setCellValue('H' . $row, $prospect->categorieProspects->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheetProspects->setCellValue('I' . $row, $prospect->utilisateur->name ?? 'Personne');
             $row++;
         }

        // ============================
        // Feuille pour les Fournisseurs
        // ============================
        $spreadsheet->createSheet();
        $sheetFournisseurs = $spreadsheet->getSheet(2);
        $sheetFournisseurs->setTitle('Fournisseurs');

        // Ajouter les en-têtes pour les fournisseurs
        $sheetFournisseurs->setCellValue('A1', 'Nom de la société');
        $sheetFournisseurs->setCellValue('B1', 'GSM1');
        $sheetFournisseurs->setCellValue('C1', 'GSM2');
        $sheetFournisseurs->setCellValue('D1', 'Nom');
        $sheetFournisseurs->setCellValue('E1', 'Téléphone');
        $sheetFournisseurs->setCellValue('F1', 'Email');
        $sheetFournisseurs->setCellValue('G1', 'Ville');
        $sheetFournisseurs->setCellValue('H1', 'Catégorie');
        $sheetFournisseurs->setCellValue('I1', 'Utilisateur');

        // Remplir les données des fournisseurs
        $row = 2;
        foreach ($fournisseurs as $fournisseur) {
             $sheetFournisseurs->setCellValue('A' . $row, $fournisseur->nomSociete_fournisseur ?? 'Particulier');
             $sheetFournisseurs->setCellValue('B' . $row, $fournisseur->GSM1_fournisseur ?? 'Non disponible');
             $sheetFournisseurs->setCellValue('C' . $row, $fournisseur->GSM2_fournisseur ?? 'Non disponible');
             $sheetFournisseurs->setCellValue('D' . $row, $fournisseur->nom_fournisseur ?? 'Non disponible');
             $sheetFournisseurs->setCellValue('E' . $row, $fournisseur->tele_fournisseur ?? 'Non disponible');
             $sheetFournisseurs->setCellValue('F' . $row, $fournisseur->email_fournisseur ?? 'Non disponible');
             $sheetFournisseurs->setCellValue('G' . $row, $fournisseur->ville_fournisseur);
             $sheetFournisseurs->setCellValue('H' . $row, $fournisseur->categorieFournisseur->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheetFournisseurs->setCellValue('I' . $row, $fournisseur->utilisateur->name ?? 'Personne');
             $row++;
         }

        // ============================
        // Feuille pour les Fournisseur-Client
        // ============================
        $spreadsheet->createSheet();
        $sheetFournisseurClients = $spreadsheet->getSheet(3);
        $sheetFournisseurClients->setTitle('Fournisseur-Clients');

        // Ajouter les en-têtes pour les fournisseur-clients
        $sheetFournisseurClients->setCellValue('A1', 'Nom de la société');
        $sheetFournisseurClients->setCellValue('B1', 'GSM1');
        $sheetFournisseurClients->setCellValue('C1', 'GSM2');
        $sheetFournisseurClients->setCellValue('D1', 'Nom');
        $sheetFournisseurClients->setCellValue('E1', 'Téléphone');
        $sheetFournisseurClients->setCellValue('F1', 'Email');
        $sheetFournisseurClients->setCellValue('G1', 'Ville');
        $sheetFournisseurClients->setCellValue('H1', 'Catégorie');
        $sheetFournisseurClients->setCellValue('I1', 'Utilisateur');

        // Remplir les données des fournisseur-clients
        $row = 2;
        foreach ($fournisseurClients as $fournisseurClient) {
             $sheetFournisseurClients->setCellValue('A' . $row, $fournisseurClient->nomSociete_fournisseurClient ?? 'Particulier');
             $sheetFournisseurClients->setCellValue('B' . $row, $fournisseurClient->GSM1_fournisseurClient ?? 'Non disponible');
             $sheetFournisseurClients->setCellValue('C' . $row, $fournisseurClient->GSM2_fournisseurClient ?? 'Non disponible');
             $sheetFournisseurClients->setCellValue('D' . $row, $fournisseurClient->nom_fournisseurClient ?? 'Non disponible');
             $sheetFournisseurClients->setCellValue('E' . $row, $fournisseurClient->tele_fournisseurClient ?? 'Non disponible');
             $sheetFournisseurClients->setCellValue('F' . $row, $fournisseurClient->email_fournisseurClient ?? 'Non disponible');
             $sheetFournisseurClients->setCellValue('G' . $row, $fournisseurClient->ville_fournisseurClient);
             $sheetFournisseurClients->setCellValue('H' . $row, $fournisseurClient->categorieClientFournisseurs->first()->categorie->nom_categorie ?? 'Non catégorisé');
             $sheetFournisseurClients->setCellValue('I' . $row, $fournisseurClient->utilisateur->name ?? 'Personne');
             $row++;
         }

        // Créer un écrivain Xlsx et forcer le téléchargement
        $writer = new Xlsx($spreadsheet);
        $fileName = 'all_data_export.xlsx';

        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
}


