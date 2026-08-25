<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class AIService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai.url');
    }

    public function analyzeApplications(array $data): array
    {
        $response = Http::timeout(120)
        ->post(
            $this->baseUrl . '/api/v1/application/summary',
            $data
            );

               logger()->info('AI response received', [
        'status' => $response->status(),
        'body' => $response->body(),
    ]);
            
        $response->throw();

        return $response->json();
    }
}