<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequirementController extends Controller
{
    public function index()
    {
        return Inertia::render('Requirements/Index');
    }

    public function create()
    {
        return Inertia::render('Requirements/Create');
    }
    
    public function show(Requirement $requirement)
    {
        return Inertia::render('Requirements/Show', [
            'requirement' => $requirement,
        ]);
    }
}
