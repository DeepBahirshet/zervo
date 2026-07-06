<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Requirement::latest()->get(),
        ]);
    }
}
