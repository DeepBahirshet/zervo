<?php

namespace App\Http\Controllers\Api\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Requirement;
use App\Models\Review;

class StoreController extends Controller
{
    public function __invoke(
        ReviewRequest $request,
        Requirement $requirement
    ) {

        abort_if(
            $requirement->user_id !== auth()->id(),
            403
        );

        abort_if(
            $requirement->status !== 'approved',
            422,
            'Project is not approved.'
        );

        abort_if(
            $requirement->review != '',
            422,
            'Review already submitted.'
        );

        $provider = $requirement->applications()
            ->where('status', 'accepted')
            ->first();

        abort_if(!$provider, 422);

        Review::create([
            'requirement_id' => $requirement->id,
            'owner_id' => auth()->id(),
            'provider_id' => $provider->user_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'message' => 'Review submitted successfully.',
        ]);
    }
}