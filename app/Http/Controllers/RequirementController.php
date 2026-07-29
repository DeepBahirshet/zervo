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
        $requirement->load(['images']);
        if($requirement->user_id === auth()->id())
        {

            $requirement->load(['applications.user']);

            return Inertia::render('Requirements/OwnerShow', [
                'requirement' => $requirement
            ]);
        }

        $requirement = $requirement->load('user');
        
        $application = $requirement->applications()->where('user_id', auth()->id())->first();

        $hasApplied = !empty($application);


        return Inertia::render('Requirements/ProviderShow', [
            'requirement' => $requirement,
            'hasApplied' => $hasApplied,
            'application' => $application
        ]);
    }
}
