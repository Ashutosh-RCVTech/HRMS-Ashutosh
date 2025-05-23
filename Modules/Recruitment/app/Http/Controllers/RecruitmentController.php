<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('recruitment::dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function apply()
    {
        return view('recruitment::apply');
    }

    public function requests()
    {
        return view('recruitment::requests');
    }
}
