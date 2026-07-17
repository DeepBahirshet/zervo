<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequirementRequest;
use App\Models\Requirement;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RequirementRequest $request)
    {
        $requirement = Requirement::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'location' => $request->location,
            'status' => 'pending',
        ]);

        return redirect()->route('requirements.index')->with('success', 'Requirement posted successfully.');
    }
}
