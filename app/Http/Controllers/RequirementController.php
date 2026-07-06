<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequirementController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Requirement::latest()->get(),
        ]);
    }

    public function show(Requirement $requirement)
    {
        return Inertia::render('Requirements/Show', [
            'requirement' => $requirement,
        ]);
    }
}
