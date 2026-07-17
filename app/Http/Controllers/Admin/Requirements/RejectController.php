<?php

namespace App\Http\Controllers\Admin\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RejectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Requirement $requirement): JsonResponse
    {
        $requirement->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'message' => 'Requirement rejected successfully.',
        ]);
    }
}
