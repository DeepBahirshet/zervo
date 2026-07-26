<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) :JsonResponse
    {
        $applications = $request->user()
            ->applications()
            ->with('requirement.user')
            ->latest()
            ->get();

        return response()->json([
            'data' => $applications
        ]);
    }
}
