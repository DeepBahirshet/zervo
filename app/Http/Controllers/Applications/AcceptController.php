<?php

namespace App\Http\Controllers\Applications;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcceptController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Application $application)
    {
        $requirement = $application->requirement;

        abort_if($requirement->user_id !== auth()->id(), 403);

        DB::transaction(function () use ($application, $requirement) {

            $application->update(['status' => 'accepted']);

            $requirement->applications()->whereKeyNot($application->id)->where('status', 'pending')->update(['status' => 'rejected']);

            $requirement->update(['status' => 'in_progress']);
        });

        return response()->json([
            'message' => 'Application accepted successfully.',
        ]);
    }
}
