<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json(['data' => Requirement::where('status', 'open')->latest()->get(),
        ]);
    }
}
