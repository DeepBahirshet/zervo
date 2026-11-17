<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $status = request('status', 'approved');

        $requirements = Requirement::where('status', $status)
            ->with(['images', 'serviceCategory'])
            ->latest()
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'data' => $requirements,
            'categories' => $categories,
        ]);
    }
}
