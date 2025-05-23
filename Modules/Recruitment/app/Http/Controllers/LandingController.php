<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\Client;
use Modules\Recruitment\Models\Location;

class LandingController extends Controller
{

    public function index()
    {
        $locations = Location::all();
        $clients = Client::all();
        return view('landing.app', compact('locations', 'clients'));
    }
}
