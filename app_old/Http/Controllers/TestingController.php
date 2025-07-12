<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\MasterAdmin;
use App\Models\Staff;
use App\Models\SystemUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class TestingController extends Controller
{
    public function index()
    {
        $key = config('services.connecteam.api_key');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.connecteam.com/time-clock/v1/time-clocks', [
            'headers' => [
                'X-API-KEY' => $key,
                'accept' => 'application/json',
            ],
            'query' => [
                'employee_id' => 11578188,  // Example employee ID filter
            ],
            'verify' => false,
        ]);

        return $response->getBody()->getContents();
        die;

        // $response = $client->request('GET', 'https://api.connecteam.com/time-clock/v1/time-clocks', [
        //     'headers' => [
        //         'X-API-KEY' => $key,
        //         'accept' => 'application/json',
        //     ],
        //     'verify' => false,
        // ]);
        // return $response->getBody()->getContents();
        // $users = $body['data']['users'];      // get array of users
        $targetUserId = 11390050;
        $foundUser = null;


        try {
            $response = $client->request('GET', 'https://api.connecteam.com/time-clocks/12308814/time-activities?startDate=2025-01-06&endDate=2025-26-06
', [
                'headers' => [
                    'X-API-KEY' => $key,
                    'accept' => 'application/json',
                ],
                'verify' => false,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $response->getBody()->getContents();

        // foreach ($users as $user) {
        //     if ($user['userId'] === $targetUserId) {
        //         $foundUser = $user;
        //         break;
        //     }
        // }

        // if ($foundUser) {
        //     echo "User found:\n";
        //     print_r($foundUser);
        // } else {
        //     echo "User with ID " . $targetUserId . " not found.\n";
        // }
        // $firstUser = $users[0];
        // return $users;

        // $connecteamApiUrl = 'https://api.connecteam.com/users/v1/users';
        // $userData = [
        //     [
        //         "userType" => "user",
        //         "isArchived" => false,
        //         "firstName" => "Ali",
        //         "lastName" => "Khan",
        //         "phoneNumber" => "+923001234567", // Important: Phone number needs to be in international format with '+'
        //         "email" => "thebabynest0@gmail.com"
        //     ]
        // ];

        // try {
        //    $response = Http::withHeaders([
        //         'X-API-KEY' => $key,
        //         'Accept' => 'application/json',
        //         'Content-Type' => 'application/json',
        //     ])->withOptions([
        //         'verify' => false, // <--- Add this line to disable SSL verification
        //     ])->post($connecteamApiUrl . '?sendActivation=false', $userData);

        //     // Check if the request was successful
        //     if ($response->successful()) {
        //         $responseData = $response->json();
        //         // Handle successful response, e.g., log it, return success message
        //         return response()->json([
        //             'message' => 'Connecteam user created successfully!',
        //             'data' => $responseData
        //         ]);
        //     } else {
        //         // Handle API error response
        //         return response()->json([
        //             'message' => 'Failed to create Connecteam user.',
        //             'status' => $response->status(),
        //             'errors' => $response->json() // Get error details from Connecteam API
        //         ], $response->status());
        //     }
        // } catch (\Exception $e) {
        //     // Handle any exceptions during the request
        //     return response()->json([
        //         'message' => 'An error occurred while trying to create Connecteam user: ' . $e->getMessage()
        //     ], 500);
        // }

    }
}
