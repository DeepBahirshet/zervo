<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Services\AI\AIService;
use Illuminate\Http\JsonResponse;

class ApplicationAnalysisController extends Controller
{
    public function __construct(
        protected AIService $aiService
    ) {
    }

    public function __invoke(
        Requirement $requirement
    ): JsonResponse {
        $requirement->load([
            'applications.user',
            ]);
            
            $data = [
                'requirement' => $requirement->title . "\n" .
                $requirement->description,
                
                'budget' => (float) $requirement->budget,
                
                'required_skills' => [],
                
                'applications' => $requirement
                ->applications
                ->map(function ($application) {
                    
                    $user = $application->user;

                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'bio' => $user->bio ?? '',
                        'experience' => 3,
                        'hourly_rate' => (float) $application->quoted_price,
                        'completed_projects' => 10,
                        'skills' => [],
                    ];
                })
                ->values()
                ->toArray(),
        ];

        return response()->json(
            $this->aiService->analyzeApplications($data)
        );
    }
}