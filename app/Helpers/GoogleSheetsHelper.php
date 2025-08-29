<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GoogleSheetsHelper
{
    protected static function getBaseUrl()
    {
        return "https://sheets.googleapis.com/v4/spreadsheets/" . env('GOOGLE_SPREADSHEET_ID') . "/values/";
    }

    public static function readSheet($range)
    {
        $accessToken = GoogleAuthHelper::getAccessToken();

        $response = Http::withToken($accessToken)
            ->get(self::getBaseUrl() . $range);

        if (!$response->successful()) {
            throw new \Exception("Google Sheets error: " . $response->body());
        }

        return $response->json()['values'] ?? [];
    }

    public static function appendRow($range, $values)
    {
        $accessToken = GoogleAuthHelper::getAccessToken();

        $response = Http::withToken($accessToken)
            ->post(self::getBaseUrl() . $range . ":append", [
                'values' => [$values]
            ], [
                'query' => ['valueInputOption' => 'RAW']
            ]);

        if (!$response->successful()) {
            throw new \Exception("Google Sheets error: " . $response->body());
        }

        return $response->json();
    }

    public static function updateRow($range, $values)
    {
        $accessToken = GoogleAuthHelper::getAccessToken();

        $response = Http::withToken($accessToken)
            ->put(self::getBaseUrl() . $range, [
                'values' => [$values]
            ], [
                'query' => ['valueInputOption' => 'RAW']
            ]);

        if (!$response->successful()) {
            throw new \Exception("Google Sheets güncelleme hatası: " . $response->body());
        }

        return $response->json();
    }

    public static function clearSheet($range)
    {
        $accessToken = GoogleAuthHelper::getAccessToken();

        $response = Http::withToken($accessToken)
            ->post(self::getBaseUrl() . $range . ":clear");

        if (!$response->successful()) {
            throw new \Exception("Google Sheets temizleme hatası: " . $response->body());
        }

        return $response->json();
    }
}