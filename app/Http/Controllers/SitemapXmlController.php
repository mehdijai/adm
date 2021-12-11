<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SitemapXmlController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::select('slug', 'created_at')->get();
        $agences = Agence::select('slug', 'created_at')->get();

        return response()->view('sitemap', compact(
            'vehicules',
            'agences',
        ))->header('Content-Type', 'text/xml');
    }
}
