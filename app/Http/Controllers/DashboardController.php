<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Marque;
use App\Models\Setting;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        /* Filter vehicules */
        $vehicules = Vehicule::where('agence_id', Auth::user()->agence->id)
            ->with('agence', 'agence.city', 'marque', 'pics')
            ->paginate(25);

        return view('agence.dashboard')
        ->with([
            'vehicules' => $vehicules,
        ]);
    }
}
