<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke():JsonResponse
    {
        $status = request('status', 'approved');

        return response()->json(['data' => Requirement::where('status', $status)->with('images')->latest()->get(),
        ]);
    }
}
