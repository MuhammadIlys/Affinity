<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConnecteamService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.connecteam.url');
        $this->apiKey = config('services.connecteam.api_key');
    }

    public function createUser(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post($this->apiUrl . '?sendActivation=false', [$data]);

            if ($response->successful()) {
                return ['success' => true, 'response' => $response->json()];
            } else {
                Log::error('Connecteam API error:', $response->json());
                return ['success' => false, 'error' => $response->json()];
            }
        } catch (\Exception $e) {
            Log::error('Connecteam Exception: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getUser($userId): array
    {
        //  $requestUrl = $this->apiUrl . '/' . $userId;
        // dd($requestUrl);

        try {
        // Only fetch active users
        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Accept'    => 'application/json',
        ])->withOptions([
            'verify' => false, // Disable SSL in dev
        ])->get($this->apiUrl . '?userStatus=active');

        if ($response->successful()) {
            $body = $response->json();
            $users = $body['data']['users'] ?? [];

            // Find the user by ID
            $foundUser = collect($users)->firstWhere('userId', (int) $userId);

            if ($foundUser) {
                return [
                    'success' => true,
                    'response' => $foundUser
                ];
            } else {
                return [
                    'success' => false,
                    'error' => "User ID {$userId} not found in the active user list."
                ];
            }
        } else {
            Log::error('Connecteam API list users error:', $response->json());
            return ['success' => false, 'error' => $response->json()];
        }
    } catch (\Exception $e) {
        Log::error('Connecteam Fetch Exception: ' . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage()];
    }
    }
}
