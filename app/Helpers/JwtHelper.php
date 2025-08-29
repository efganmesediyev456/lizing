<?php

namespace App\Helpers;

class JwtHelper
{
    public static function createJwtAssertion($credentials)
    {
        $now = time();
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $payload = [
            'iss'   => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/spreadsheets',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'exp'   => $now + 3600,
            'iat'   => $now
        ];

        // Base64URL Encode (padding = '=' silinmis)
        $base64UrlHeader = self::base64UrlEncode(json_encode($header));
        $base64UrlPayload = self::base64UrlEncode(json_encode($payload));

        // İmzalama (RSA SHA256)
        $privateKey = openssl_pkey_get_private($credentials['private_key']);
        openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $privateKey, "sha256");

        return $base64UrlHeader . "." . $base64UrlPayload . "." . self::base64UrlEncode($signature);
    }

    private static function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}