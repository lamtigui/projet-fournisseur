<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SousCategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClassificationsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\FournisseurClientController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\ProfileAuthController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\HistoriqueJournauxController;
use App\Http\Controllers\PartiesPrenantesController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PermissionController;
use App\Exports\ClientsExport;

use App\Models\Categorie;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\FournisseurClient;
use App\Models\Prospect;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route pour afficher la page de connexion, protégée par le middleware 'guest'
Route::get('/', [UserController::class, 'viewLogin'])->middleware('guest');

// Route pour se connecter, protégée par le middleware 'guest'
Route::post('/', [UserController::class, 'login'])->name('login')->middleware('guest');

// Route pour se déconnecter, nécessite l'authentification
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// Routes protégées par le middleware 'auth' et 'checkAdmins_Users'
Route::get('/dashboardSection', [ChartController::class, 'index'])->name('dashboardSection')->middleware('checkAdmins_Users', 'auth');
Route::get('/data-for-charts-by-date', [ChartController::class, 'getDataForChartsByDate']);
Route::get('/data-for-line-chart-by-date', [ChartController::class, 'getDataForLineChartByDate']);

// Routes réservées aux Super Admins
Route::get('/usersSection', [UserController::class, 'index'])
    ->name('usersSection')
    ->middleware(['auth', 'checkSuperAdmin']);

Route::post('/addUser', [UserController::class, 'store'])->middleware('checkSuperAdmin');
Route::get('/editUser', [UserController::class, 'edit'])->middleware('checkSuperAdmin');
Route::post('/updateUser', [UserController::class, 'update'])->middleware('checkSuperAdmin');
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('checkSuperAdmin');

// Routes pour les fournisseurs, prospects, clients, etc.
Route::get('/suppliersSection', [FournisseurController::class, 'index'])->name('suppliersSection')->middleware('checkAdmins_Users');
Route::get('/suppliersSection/{id}', [FournisseurController::class, 'fournisseur'])->middleware('checkAdmins');
Route::post('/addSupplier', [FournisseurController::class, 'store'])->middleware('checkAdmins');
Route::post('/updateSupplier', [FournisseurController::class, 'update'])->middleware('checkAdmins');
Route::delete('/deleteSupplier/{id}', [FournisseurController::class, 'destroy'])->name('supplier.destroy')->middleware('checkSuperAdmin');

// Routes pour les prospects
Route::get('/prospectsSection', [ProspectController::class, 'index'])->name('prospectsSection')->middleware('checkAdmins_Users');
Route::post('/addProspect', [ProspectController::class, 'store'])->name('prospect.add')->middleware('checkAdmins_Users');
Route::delete('/deleteProspect/{id}', [ProspectController::class, 'destroy'])->name('prospect.destroy')->middleware('checkSuperAdmin');
Route::post('/updateProspect', [ProspectController::class, 'update'])->name('prospect.update')->middleware('checkAdmins');

// Routes pour les clients
Route::get('/clientsSection', [ClientController::class, 'index'])->name('clientsSection')->middleware('checkAdmins_Users');
Route::post('/addClient', [ClientController::class, 'store'])->name('client.add')->middleware('checkAdmins_Users');
Route::delete('/deleteClient/{id}', [ClientController::class, 'destroy'])->name('client.destroy')->middleware('checkSuperAdmin');
Route::post('/updateClient', [ClientController::class, 'update'])->name('client.update')->middleware('checkAdmins');

// Routes pour les fournisseurs et clients
Route::get('/suppliersAndClientsSection', [FournisseurClientController::class, 'index'])->name('suppliersAndClientsSection')->middleware('checkAdmins_Users');
Route::post('/addFournisseurClient', [FournisseurClientController::class, 'store'])->name('fournisseurClient.add')->middleware('checkAdmins_Users');
Route::delete('/deleteFournisseurClient/{id}', [FournisseurClientController::class, 'destroy'])->name('fournisseurClient.destroy')->middleware('checkSuperAdmin');
Route::post('/updateFournisseurClient', [FournisseurClientController::class, 'update'])->name('fournisseurClient.update')->middleware('checkAdmins');

// Routes pour les catégories
Route::get('/categoriesSection', [CategorieController::class, 'index'])->name('categoriesSection')->middleware('checkAdmins_Users');
Route::post('/addCategory', [CategorieController::class, 'store'])->middleware('checkAdmins');
Route::get('/editCategory', [CategorieController::class, 'edit'])->middleware('checkAdmins');
Route::post('/updateCategory', [CategorieController::class, 'update'])->middleware('checkAdmins');
Route::delete('/deleteCategory/{id}', [CategorieController::class, 'destroy'])->name('category.destroy')->middleware('checkSuperAdmin');

// Routes pour les produits
Route::get('/productsSection', [SousCategorieController::class, 'index'])->name('productsSection')->middleware('checkAdmins_Users');
Route::post('/addSousCategory', [SousCategorieController::class, 'store'])->middleware('checkAdmins');
Route::get('/editProduct', [SousCategorieController::class, 'edit'])->middleware('checkAdmins');
Route::post('/updateProduct', [SousCategorieController::class, 'update'])->middleware('checkAdmins');
Route::delete('/deleteProduct/{id}', [SousCategorieController::class, 'destroy'])->name('product.destroy')->middleware('checkSuperAdmin');

// Recherche de différents éléments
Route::get('/search-users', [UserController::class, 'search'])->name('search.users');
Route::get('/search-prospects', [ProspectController::class, 'search'])->name('search.prospects');
Route::get('/search-clients', [ClientController::class, 'search'])->name('search.clients');
Route::get('/search-suppliers', [FournisseurController::class, 'search'])->name('search.suppliers');
Route::get('/search-fournisseurClients', [FournisseurClientController::class, 'search'])->name('search.fournisseurClients');
Route::get('/search-categories', [CategorieController::class, 'search'])->name('search.categories');
Route::get('/search-products', [SousCategorieController::class, 'search'])->name('search.products');

// Suppression de différents éléments
Route::delete('/product/destroy/{id}', [SousCategorieController::class, 'destroy'])->middleware('checkSuperAdmin');
Route::delete('/category/destroy/{id}', [CategorieController::class, 'destroy'])->middleware('checkSuperAdmin');
Route::delete('/supplier/destroy/{id}', [FournisseurController::class, 'destroy'])->middleware('checkSuperAdmin');
Route::delete('/prospect/destroy/{id}', [ProspectController::class, 'destroy'])->middleware('checkSuperAdmin');
Route::delete('/client/destroy/{id}', [ClientController::class, 'destroy'])->middleware('checkSuperAdmin');
Route::delete('/fournisseurClient/destroy/{id}', [FournisseurClientController::class, 'destroy'])->middleware('checkSuperAdmin');

// Sélection de fournisseur, prospect, client, etc.
Route::post('/prospect/{id}', [ProspectController::class, 'prospect'])->name('prospect.select');
Route::post('/supplier/{id}', [FournisseurController::class, 'fournisseur'])->name('supplier.select');
Route::post('/client/{id}', [ClientController::class, 'client'])->name('client.select');
Route::post('/fournisseurClient/{id}', [FournisseurClientController::class, 'fournisseurClient'])->name('fournisseurClient.select');

// Routes pour la mise à jour du profil utilisateur
Route::get('/updateAuth', [ProfileAuthController::class, 'showUpdateForm'])->name('update.user.auth.form')->middleware('auth');
Route::post('/updateAuth', [ProfileAuthController::class, 'updateUser'])->name('update.user.auth')->middleware('auth');
Route::post('/update-security', [ProfileAuthController::class, 'updateSecurity'])->name('updateSecurity')->middleware('auth');

// Pagination
Route::get('/users/pagination', [UserController::class, 'index'])->name('users.pagination');
Route::get('/categories/pagination', [CategorieController::class, 'index'])->name('categories.pagination');
Route::get('/sousCategories/pagination', [SousCategorieController::class, 'index'])->name('sousCategories.pagination');
Route::get('/prospects/pagination', [ProspectController::class, 'index'])->name('prospects.pagination');
Route::get('/fournisseurs/pagination', [FournisseurController::class, 'index'])->name('fournisseurs.pagination');
Route::get('/clients/pagination', [ClientController::class, 'index'])->name('clients.pagination');
Route::get('/fournisseurClients/pagination', [FournisseurClientController::class, 'index'])->name('fournisseurClients.pagination');

// Export PDF des données
Route::get('/users/pdf', [UserController::class, 'usersPdf'])->name('users.pdf');
Route::get('/categories/pdf', [CategorieController::class, 'categoriesPdf'])->name('categories.pdf');
Route::get('/sousCategories/pdf', [SousCategorieController::class, 'sousCategoriesPdf'])->name('sousCategories.pdf');
Route::get('/prospects/pdf', [ProspectController::class, 'prospectsPdf'])->name('prospects.pdf');
Route::get('/fournisseurs/pdf', [FournisseurController::class, 'fournisseursPdf'])->name('fournisseurs.pdf');
Route::get('/clients/pdf', [ClientController::class, 'clientsPdf'])->name('clients.pdf');
Route::get('/fournisseurClients/pdf', [FournisseurClientController::class, 'fournisseurClientsPdf'])->name('fournisseurClients.pdf');
Route::get('/allData/pdf', [ExportController::class, 'allDataPdf'])->name('allData.pdf');


// Contact des utilisateurs
Route::post('/contactSupplier/user/{id}', [FournisseurController::class, 'updateUserFournisseur'])->name('user.select');
Route::post('/contactProspect/user/{id}', [ProspectController::class, 'updateUserProspect'])->name('user.select.prospect');
Route::post('/contactClient/user/{id}', [ClientController::class, 'updateUserClient'])->name('user.select.client');
Route::post('/contactFournisseurClient/user/{id}', [FournisseurClientController::class, 'updateUserFC'])->name('user.select.fc');

// Mise à jour des remarques pour chaque type d'utilisateur
Route::post('/contactSupplier/remark/{id}', [FournisseurController::class, 'updateRemarkFournisseur'])->name('remark');
Route::post('/contactProspect/remark/{id}', [ProspectController::class, 'updateRemarkProspect'])->name('remark.prospect');
Route::post('/contactClient/remark/{id}', [ClientController::class, 'updateRemarkClient'])->name('remark.client');
Route::post('/contactFournisseurClient/remark/{id}', [FournisseurClientController::class, 'updateRemarkFC'])->name('remark.fc');

// Route pour l'historique
Route::get('/historique',[HistoriqueController::class,'showHistorique'])->name('historiqueSection');
Route::get('/historique', [HistoriqueController::class, 'index'])->name('historique')->middleware('checkAdmins');






Route::get('/sous-categories/{categorieId}', [CategorieController::class, 'getSousCategories']);


Route::get('/journaux', [ActivityLogController::class, 'index'])->name('journaux.index')->middleware(['checkSuperAdmin']);
Route::get('/export/excel', [ExportController::class, 'exportAllDataExcel'])->name('export.excel');
Route::get('/export/users', [ExportController::class, 'exportUsersExcel'])->name('export.users');
Route::get('/export/clients', [ExportController::class, 'exportclients'])->name('export.clients');
Route::get('/export/prospects', [ExportController::class, 'exportprospects'])->name('export.prospects');
Route::get('/export/categories', [ExportController::class, 'exportCategoriesExcel'])->name('export.categories');
Route::get('/export/allcategories', [ExportController::class, 'exportAllDataCategorieExcel'])->name('export.allcategories');
Route::get('/export/sous-categories', [ExportController::class, 'exportSousCategoriesExcel'])->name('export.sous-categories');
Route::get('/export/fournisseurs', [ExportController::class, 'exportfournisseurs'])->name('export.fournisseurs');
Route::get('/export/fournisseurClients', [ExportController::class, 'exportfournisseurClients'])->name('export.fournisseurClients');

Route::prefix('admin/permissions')->middleware(['auth'])->group(function () {
    Route::get('/{user}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::put('/{user}', [PermissionController::class, 'update'])->name('admin.permissions.update');
});