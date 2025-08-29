<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GoogleAuthHelper
{
    public static function getAccessToken()
    {
        $credentialsPath = storage_path('app/credentials.json');

        if (!file_exists($credentialsPath)) {
            throw new \Exception("Google API credentials.json doesnt exists.");
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => JwtHelper::createJwtAssertion($credentials),
        ]);

        if (!$response->successful()) {
            throw new \Exception("Google API error: " . $response->body());
        }

        return $response->json()['access_token'];
    }
}