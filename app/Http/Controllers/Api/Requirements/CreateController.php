<?php

namespace App\Http\Controllers\Api\Requirements;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequirementRequest;
use App\Models\Requirement;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RequirementRequest $request)
    {
        $validated = $request->validated();

        $requirement = Requirement::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'budget' => $validated['budget'],
            'location' => $validated['location'],
            'status' => 'pending',
            'work_status' => 'open',
        ]);

        if ($request->hasFile('images')) {
            $imageData = [];

            $folderPath = 'requirements/' . $requirement->id;

            foreach ($request->file('images') as $image) {
                $imageData[] = [
                    'image' => $image->store($folderPath, 'public'),
                ];
            }

            $requirement->images()->createMany($imageData);
        }

        return redirect()
            ->route('requirements.index')
            ->with('success', 'Requirement posted successfully.');
    }
}
