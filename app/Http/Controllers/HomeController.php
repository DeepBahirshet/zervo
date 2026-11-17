<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRequirements = Requirement::query()
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('HomePage', [
            'featuredRequirements' => $featuredRequirements,
        ]);
    }
}