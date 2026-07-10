<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}
