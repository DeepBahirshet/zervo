<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Models\Requirement;

class CompleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Requirement $requirement)
    {
        abort_if($requirement->user_id !== auth()->id(), 403);

        $requirement->update([
            'work_status' => 'completed',
        ]);

        return response()->json([
            'message' => 'Project marked as completed.',
        ]);
    }
}
