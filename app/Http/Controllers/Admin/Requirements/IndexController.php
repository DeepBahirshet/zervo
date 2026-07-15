<?php

namespace App\Http\Controllers\Admin\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $requirements = Requirement::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return Inertia::render('Admin/Requirements/Index', [
            'requirements' => $requirements,
        ]);
    }
}
