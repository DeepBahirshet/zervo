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
        if($requirement->user_id === auth()->id())
        {

            $requirement->load(['applications.user']);

            return Inertia::render('Requirements/OwnerShow', [
                'requirement' => $requirement
            ]);
        }

        $hasApplied = $requirement->applications()->where('user_id', auth()->id())->exists();

        return Inertia::render('Requirements/ProviderShow', [
            'requirement' => $requirement,
            'hasApplied' => $hasApplied
        ]);
    }
}
