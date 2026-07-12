<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Requirement;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        ApplicationRequest $request,
        Requirement $requirement
    ): JsonResponse {

        if ($requirement->user_id === $request->user()->id) {
            return response()->json([
                'message' => 'You cannot apply to your own requirement.'
            ], 422);
        }

        $alreadyApplied = Application::where([
            'requirement_id' => $requirement->id,
            'user_id' => $request->user()->id,
        ])->exists();

        if ($alreadyApplied) {
            return response()->json([
                'message' => 'You have already applied for this requirement.'
            ], 422);
        }

        $application = Application::create([
            'requirement_id' => $requirement->id,
            'user_id' => $request->user()->id,
            'message' => $request->message,
            'quoted_price' => $request->quoted_price,
            'estimated_days' => $request->estimated_days,
            'status' => 'pending',
        ]);

        return redirect('');
    }
}
