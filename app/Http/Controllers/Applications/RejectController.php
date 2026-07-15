<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RejectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Application $application): JsonResponse
    {
        $requirement = $application->requirement;

        abort_if($requirement->user_id !== auth()->id(), 403);

        $application->update([
            'status' => 'rejected',
        ]);

        return response()->json([
        'message' => 'Application rejected successfully.',
        ]);
    }
}
