<?php

namespace App\Http\Controllers\Api\Admin\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $status = request('status', 'pending');
        $requirement = Requirement::with('user')->where('status', $status)->latest()->get();

        return response()->json(['data' => $requirement]);
    }
}
