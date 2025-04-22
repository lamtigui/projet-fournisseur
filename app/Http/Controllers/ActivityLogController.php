<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public static function logActivity($action, $type, $description = null)
    {
        ActivityLog::create([
            'action' => $action,
            'type' => $type,
            'description' => $description,
            'user_id' => Auth::id(), // ID de l'utilisateur connecté
        ]);
    }

    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->get('search');

        // If there's a search query, filter the logs by user name
        if ($search) {
            $logs = ActivityLog::whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');  // Search by user name
            })->latest()->paginate(10); // Paginate results, 10 per page;
        } else {
            // If no search query, get all logs with pagination
            $logs = ActivityLog::latest()->paginate(10); // Paginate results, 10 per page
        }

        return view('myApp.admin.links.journaux', compact('logs'));
    }

}

