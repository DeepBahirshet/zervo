<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function categories(): Response
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::where('is_active', true)
                ->withCount([
                    'requirements' => function ($query) {
                        $query->where('status', 'approved');
                    },
                ])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About/Index');
    }

    public function insights(): Response
    {
        return Inertia::render('Insights/Index');
    }
}
