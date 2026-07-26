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
        $status = request('status', 'approved');

        return response()->json(['data' => Requirement::where('status', $status)->latest()->get(),
        ]);
    }
}
