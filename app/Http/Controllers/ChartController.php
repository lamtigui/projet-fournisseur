<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fournisseur;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\SousCategorieUser;
use App\Models\Prospect;
use App\Models\Client;
use App\Models\FournisseurClient;
use App\Models\Historique;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ChartController extends Controller
{
    public function index()
    {
        //suppliers&client PART DASHBORD
        $currentFournClientsCount = FournisseurClient::count();
        $setting = Setting::where('key', 'FournisseurClientTracking')->first();
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'FournisseurClientTracking',
                'value' => $currentFournClientsCount,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Calculate the changes in suppliers (additions and deletions)
        $FournClientsAddedToday = $setting->addedToday;
        $FournClientsDeletedToday = $setting->deletedToday;

        $fournClientsChange = ($FournClientsAddedToday - $FournClientsDeletedToday);

        // Update the suppliers count in settings
        $setting->update([
            'value' => $currentFournClientsCount, // Update the total suppliers count
            'addedToday' => 0, // Reset added count for the day
            'deletedToday' => 0, // Reset deleted count for the day
        ]);




        //suppliers PART DASHBORD
        // Get the current count of suppliers
        $currentSuppliersCount = Fournisseur::count();

        // Retrieve the current settings for suppliers tracking
        $setting = Setting::where('key', 'suppliersTracking')->first();

        // If settings are not found, initialize them
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'suppliersTracking',
                'value' => $currentSuppliersCount,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Calculate the changes in suppliers (additions and deletions)
        $suppliersAddedToday = $setting->addedToday;
        $suppliersDeletedToday = $setting->deletedToday;

        $suppliersChange = ($suppliersAddedToday - $suppliersDeletedToday);

        // Update the suppliers count in settings
        $setting->update([
            'value' => $currentSuppliersCount, // Update the total suppliers count
            'addedToday' => 0, // Reset added count for the day
            'deletedToday' => 0, // Reset deleted count for the day
        ]);



        //CLIENTS PART DASHBORD
        // Get the current count of clients
        $currentClientsCount = Client::count();

        // Retrieve the current settings for clients tracking
        $setting = Setting::where('key', 'clientsTracking')->first();

        // If settings are not found, initialize them
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'clientsTracking',
                'value' => $currentClientsCount,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Get the previous count of clients
        $previousClientsCount = $setting->value;

        // Calculate the changes in clients (additions and deletions)
        $clientsAddedToday = $setting->addedToday;
        $clientsDeletedToday = $setting->deletedToday;

        $clientsChange = ($clientsAddedToday - $clientsDeletedToday);

        // Update the clients count in settings
        $setting->update([
            'value' => $currentClientsCount, // Update the total clients count
            'addedToday' => 0, // Reset added count for the day
            'deletedToday' => 0, // Reset deleted count for the day
        ]);



        //TIERS PART DASHBORD
        // Get the current count of prospects (Les Tiers)
        $currentTiersCount = Prospect::count();

        // Retrieve the current settings for tiers tracking
        $setting = Setting::where('key', 'tiersTracking')->first();

        // If settings are not found, initialize them
        if (!$setting) {
            $setting = Setting::create([
                'key' => 'tiersTracking',
                'value' => $currentTiersCount,
                'addedToday' => 0,
                'deletedToday' => 0,
            ]);
        }

        // Get the previous count of tiers
        $previousTiersCount = $setting->value;

        // Calculate the changes in tiers (additions and deletions)
        $addedToday = $setting->addedToday;
        $deletedToday = $setting->deletedToday;

        $tiersChange = ($addedToday - $deletedToday);

        // Update the tiers count in settings
        $setting->update([
            'value' => $currentTiersCount, // Update the total tiers count
            'addedToday' => 0, // Reset added count for the day
            'deletedToday' => 0, // Reset deleted count for the day
        ]);



        //ALL PART DASHBORD
        // Fetch other data for the dashboard (same as before)
        $sumUsers = User::count();
        $sumSuppliers = Fournisseur::count();
        $sumCategories = Categorie::count();
        $sumClients = Client::count();
        $sumFournClients = FournisseurClient::count();
        $sumTiers = $currentTiersCount;


        $categories = Categorie::withCount('sousCategories')->get();
        $categoryNames = $categories->pluck('nom_categorie');
        $subcategoryCounts = $categories->pluck('sous_categories_count');
        $suppliersNumberByCategory = Categorie::withCount('fournisseurs')->take(6)->get();

        $lastUsers = User::orderBy('created_at', 'desc');
        $lastLogin = Historique::orderBy('created_at', 'desc')
            ->take(6)->get();

        $historiques = \App\Models\Historique::with('user')
            ->orderBy('login_at', 'desc')
            ->take(6)->get();

        // Return the view with all the data, including the tiers change
        return view('myApp.admin.links.chart', compact(
            'sumUsers',
            'sumSuppliers',
            'sumCategories',
            'categoryNames',
            'subcategoryCounts',
            'suppliersNumberByCategory',
            'lastUsers',
            'sumClients',
            'sumFournClients',
            'lastLogin',
            'historiques',
            'sumTiers',
            'tiersChange',
            'clientsChange',
            'suppliersChange',
            'fournClientsChange'
        ));
    }

    // Call this method when a tier is added
    public function trackTierAdded(Request $request)
    {
        /*// Create a new prospect
        Prospect::create($request->all());*/
        Prospect::create([
            'nom_prospect' => $request->nom_prospect,
            'email_prospect' => $request->email_prospect,
            'tele_prospect' => $request->tele_prospect,
            'ville_prospect' => $request->ville_prospect,
            'nomSociete_prospect' => $request->nomSociete_prospect,
            'user_id' => $request->user_id,
            'remark' => $request->remark,
        ]);


        $setting = Setting::where('key', 'tiersTracking')->first();
        if ($setting) {



            // Make sure the increment works properly
            $setting->increment('addedToday');
        } else {
            // Handle case where setting is not found
            dd('Setting not found');
        }


        return redirect()->back()->with('message', 'Prospect added successfully.');
    }

    public function trackTierDeleted($id)
    {
        // Delete the prospect
        Prospect::destroy($id);

        // Update the 'deletedToday' in the settings table
        $setting = Setting::where('key', 'tiersTracking')->first();
        if ($setting) {



            $setting->increment('deletedToday');
        }

        return redirect()->back()->with('message', 'Prospect deleted successfully.');
    }

    public function trackClientAdded(Request $request)
    {
        // Create a new client
        Client::create([
            'nom_client' => $request->nom_client,
            'email_client' => $request->email_client,
            'tele_client' => $request->tele_client,
            'adresse_client' => $request->adresse_client,
            'user_id' => $request->user_id,
        ]);

        // Retrieve the settings for client tracking
        $setting = Setting::where('key', 'clientsTracking')->first();
        if ($setting) {


            // Increment the 'addedToday' count
            $setting->increment('addedToday');

            // Recalculate clientsChange after adding the client
            $clientsAddedToday = $setting->addedToday;
            $clientsDeletedToday = $setting->deletedToday;
            $clientsChange = $clientsAddedToday - $clientsDeletedToday;

            // Pass the updated value back to the view
            return redirect()->back()->with('message', 'Client added successfully.')
                ->with('clientsChange', $clientsChange);
        }

        return redirect()->back()->with('message', 'Client added successfully.');
    }



    public function trackClientDeleted($id)
    {
        // Delete the client
        Client::destroy($id);

        // Retrieve the settings for client tracking
        $setting = Setting::where('key', 'clientsTracking')->first();
        if ($setting) {


            // Increment the 'deletedToday' count
            $setting->increment('deletedToday');

            // Recalculate clientsChange after deleting the client
            $clientsAddedToday = $setting->addedToday;
            $clientsDeletedToday = $setting->deletedToday;
            $clientsChange = $clientsAddedToday - $clientsDeletedToday;

            // Pass the updated value back to the view
            return redirect()->back()->with('message', 'Client deleted successfully.')
                ->with('clientsChange', $clientsChange);
        }

        return redirect()->back()->with('message', 'Client deleted successfully.');
    }

    public function trackSupplierAdded(Request $request)
    {
        // Create a new supplier
        Fournisseur::create([
            'nom_fournisseur' => $request->nom_fournisseur,
            'email_fournisseur' => $request->email_fournisseur,
            'tele_fournisseur' => $request->tele_fournisseur,
            'adresse_fournisseur' => $request->adresse_fournisseur,
            'user_id' => $request->user_id,
        ]);

        // Retrieve the settings for supplier tracking
        $setting = Setting::where('key', 'suppliersTracking')->first();
        if ($setting) {


            // Increment the 'addedToday' count
            $setting->increment('addedToday');
        } else {
            // Handle the case where the setting is not found
            dd('Setting not found');
        }

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Supplier added successfully.');
    }

    public function trackSupplierDeleted($id)
    {
        // Delete the supplier by ID
        Fournisseur::destroy($id);

        // Retrieve the settings for supplier tracking
        $setting = Setting::where('key', 'suppliersTracking')->first();
        if ($setting) {


            // Increment the 'deletedToday' count
            $setting->increment('deletedToday');
        }

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Supplier deleted successfully.');
    }

    public function trackFournClientsAdded(Request $request)
    {
        // Create a new FournisseurClient
        FournisseurClient::create([
            'nom_fournisseur' => $request->nom_fournisseur,
            'email_fournisseur' => $request->email_fournisseur,
            'tele_fournisseur' => $request->tele_fournisseur,
            'ville_fournisseur' => $request->ville_fournisseur,
            'nomSociete_fournisseur' => $request->nomSociete_fournisseur,
            'user_id' => $request->user_id, // assuming this field exists
            'remark' => $request->remark, // if applicable
        ]);

        // Get the setting for FournisseurClient tracking
        $setting = Setting::where('key', 'FournisseurClientTracking')->first();
        if ($setting) {
            // Increment the 'addedToday' count in the settings
            $setting->increment('addedToday');
        } else {
            // Handle case where the setting is not found
            dd('Setting not found');
        }

        return redirect()->back()->with('message', 'FournisseurClient added successfully.');
    }

    public function trackFournClientsDeleted($id)
    {
        // Delete the FournisseurClient
        FournisseurClient::destroy($id);

        // Update the 'deletedToday' count in the settings table
        $setting = Setting::where('key', 'FournisseurClientTracking')->first();
        if ($setting) {
            // Increment the 'deletedToday' count in the settings
            $setting->increment('deletedToday');
        }

        return redirect()->back()->with('message', 'FournisseurClient deleted successfully.');
    }






    public function getDataForChartsByDate(Request $request)
    {
        $period = $request->input('period');
        $data = [];

        // Set the locale to French for month names
        Carbon::setLocale('fr');

        if ($period == 1) {  // For "Cette semaine"
            // Weekly data
            $dates = [];
            for ($i = 6; $i >= 0; $i--) {
                $dates[] = Carbon::now()->subDays($i)->format('m/d/Y');
            }

            foreach ($dates as $date) {
                $count = DB::table('clients')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();
                $count += DB::table('prospects')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();
                $count += DB::table('fournisseurs')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();
                $count += DB::table('fournisseur_clients')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();
                $data[$date] = $count;
            }
        } elseif ($period == 2) {  // For "Aujourd'hui"
            // Today's data in 2-hour intervals: 00:00-01:59, 02:00-03:59, etc.
            $today = Carbon::now()->format('Y-m-d');

            for ($hour = 0; $hour < 24; $hour += 2) {
                $startTime = Carbon::parse($today)->addHours($hour)->format('H:i:s');
                $endTime = Carbon::parse($today)->addHours($hour + 2)->subSecond()->format('H:i:s');  // Subtract 1 second to get 01:59 instead of 02:00

                $count = DB::table('clients')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                $count += DB::table('prospects')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                $count += DB::table('fournisseurs')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                $count += DB::table('fournisseur_clients')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                // Format the label as "00:00-01:59", "02:00-03:59", etc.
                $label = Carbon::parse($today)->addHours($hour)->format('H:i') . ' - ' . Carbon::parse($today)->addHours($hour + 2)->subSecond()->format('H:i');
                $data[$label] = $count;
            }
        } elseif ($period == 3) {  // For "Ce mois-ci"
            // Get the current month and break it into 7-day periods
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            // Initialize variables for grouping the data
            $currentPeriodStart = $startDate;
            $periodIndex = 1;

            while ($currentPeriodStart <= $endDate) {
                // Calculate the end of the current period (7 days later)
                $currentPeriodEnd = $currentPeriodStart->copy()->addDays(6);
                if ($currentPeriodEnd > $endDate) {
                    $currentPeriodEnd = $endDate;
                }

                // Get the label for the period (e.g., "1-7", "8-14", etc.)
                $periodLabel = $currentPeriodStart->format('d') . ' - ' . $currentPeriodEnd->format('d');

                // Count the "Parties Prenantes" for this period
                $count = DB::table('clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('prospects')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('fournisseurs')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('fournisseur_clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Store the count for this period
                $data[$periodLabel] = $count;

                // Move to the next 7-day period
                $currentPeriodStart = $currentPeriodStart->addDays(7);
            }
        } elseif ($period == 4) {  // For "Cette année" (This year)
            // Get the current year and break it into months
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();

            // Initialize variables for grouping the data
            $currentPeriodStart = $startDate;
            $months = [
                'Janvier',
                'Février',
                'Mars',
                'Avril',
                'Mai',
                'Juin',
                'Juillet',
                'Août',
                'Septembre',
                'Octobre',
                'Novembre',
                'Décembre'
            ];

            foreach ($months as $index => $month) {
                // Get the start and end dates for the current month
                $currentPeriodEnd = $currentPeriodStart->copy()->endOfMonth();

                // Get the label for the month
                $monthLabel = $month;

                // Count the "Parties Prenantes" for this period
                $count = DB::table('clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('prospects')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('fournisseurs')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();
                $count += DB::table('fournisseur_clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Store the count for this month
                $data[$monthLabel] = $count;

                // Move to the next month
                $currentPeriodStart = $currentPeriodStart->addMonth();
            }
        }

        return response()->json($data);
    }

    public function getDataForLineChartByDate(Request $request)
    {
        $period = $request->input('period');
        $data = [
            'fournisseurs' => [],
            'fournisseur_clients' => []
        ];

        // Set the locale to French for month names
        Carbon::setLocale('fr');
        if ($period == 1) {  // For "Cette semaine" (weekly data)
            $dates = [];
            for ($i = 6; $i >= 0; $i--) {
                $dates[] = Carbon::now()->subDays($i)->format('m/d/Y');
            }

            foreach ($dates as $date) {
                // Get the count of fournisseurs
                $fournisseursCount = DB::table('fournisseurs')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();
                // Get the count of fournisseur_clients
                $fournisseurClientsCount = DB::table('fournisseur_clients')->whereDate('created_at', Carbon::createFromFormat('m/d/Y', $date))->count();

                // Store data for both counts
                $data['fournisseurs'][$date] = $fournisseursCount;
                $data['fournisseur_clients'][$date] = $fournisseurClientsCount;
            }
        } elseif ($period == 2) {  // For "Aujourd'hui" (Today's data in 2-hour intervals)
            $today = Carbon::now()->format('Y-m-d');

            for ($hour = 0; $hour < 24; $hour += 2) {
                $startTime = Carbon::parse($today)->addHours($hour)->format('H:i:s');
                $endTime = Carbon::parse($today)->addHours($hour + 2)->subSecond()->format('H:i:s');  // Subtract 1 second to get 01:59 instead of 02:00

                // Get the count of fournisseurs
                $fournisseursCount = DB::table('fournisseurs')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                // Get the count of fournisseur_clients
                $fournisseurClientsCount = DB::table('fournisseur_clients')
                    ->whereDate('created_at', $today)
                    ->whereTime('created_at', '>=', $startTime)
                    ->whereTime('created_at', '<=', $endTime)
                    ->count();

                // Format the label as "00:00-01:59", "02:00-03:59", etc.
                $label = Carbon::parse($today)->addHours($hour)->format('H:i') . ' - ' . Carbon::parse($today)->addHours($hour + 2)->subSecond()->format('H:i');

                // Store data for both counts
                $data['fournisseurs'][$label] = $fournisseursCount;
                $data['fournisseur_clients'][$label] = $fournisseurClientsCount;
            }
        } elseif ($period == 3) {  // For "Ce mois-ci"
            // Get the current month and break it into 7-day periods
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            // Initialize variables for grouping the data
            $currentPeriodStart = $startDate;
            $periodIndex = 1;

            while ($currentPeriodStart <= $endDate) {
                // Calculate the end of the current period (7 days later)
                $currentPeriodEnd = $currentPeriodStart->copy()->addDays(6);
                if ($currentPeriodEnd > $endDate) {
                    $currentPeriodEnd = $endDate;
                }

                // Get the label for the period (e.g., "1-7", "8-14", etc.)
                $periodLabel = $currentPeriodStart->format('d') . ' - ' . $currentPeriodEnd->format('d');

                // Get the count of fournisseurs
                $fournisseursCount = DB::table('fournisseurs')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Get the count of fournisseur_clients
                $fournisseurClientsCount = DB::table('fournisseur_clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Store data for both counts
                $data['fournisseurs'][$periodLabel] = $fournisseursCount;
                $data['fournisseur_clients'][$periodLabel] = $fournisseurClientsCount;

                // Move to the next 7-day period
                $currentPeriodStart = $currentPeriodStart->addDays(7);
            }
        } elseif ($period == 4) {  // For "Cette année" (This year)
            // Get the current year and break it into months
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();

            // Initialize variables for grouping the data
            $currentPeriodStart = $startDate;
            $months = [
                'Janvier',
                'Février',
                'Mars',
                'Avril',
                'Mai',
                'Juin',
                'Juillet',
                'Août',
                'Septembre',
                'Octobre',
                'Novembre',
                'Décembre'
            ];

            foreach ($months as $index => $month) {
                // Get the start and end dates for the current month
                $currentPeriodEnd = $currentPeriodStart->copy()->endOfMonth();

                // Get the label for the month
                $monthLabel = $month;

                // Get the count of fournisseurs
                $fournisseursCount = DB::table('fournisseurs')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Get the count of fournisseur_clients
                $fournisseurClientsCount = DB::table('fournisseur_clients')
                    ->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])
                    ->count();

                // Store data for both counts
                $data['fournisseurs'][$monthLabel] = $fournisseursCount;
                $data['fournisseur_clients'][$monthLabel] = $fournisseurClientsCount;

                // Move to the next month
                $currentPeriodStart = $currentPeriodStart->addMonth();
            }
        }

        return response()->json($data);
    }
}
