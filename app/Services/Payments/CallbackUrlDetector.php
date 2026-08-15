<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Request;

class CallbackUrlDetector
{
    /**
     * Dynamically detect and generate live-ready HTTPS webhook callback URLs.
     *
     * @param string $routeName The named route (e.g., 'webhooks.mpesa')
     * @param string $fallbackPath Fallback path if route name is not bound (e.g., '/webhooks/mpesa')
     * @return string Validated live HTTPS or local callback URL
     */
    public static function getWebhookUrl(string $routeName, string $fallbackPath = ''): string
    {
        try {
            $url = route($routeName);
        } catch (\Exception $e) {
            $url = url($fallbackPath);
        }

        return static::ensureLiveHttpsScheme($url);
    }

    /**
     * Dynamically detect and generate live-ready HTTPS return/redirect URLs.
     *
     * @param string $routeName
     * @param array $parameters
     * @return string
     */
    public static function getReturnUrl(string $routeName, array $parameters = []): string
    {
        try {
            $url = route($routeName, $parameters);
        } catch (\Exception $e) {
            $url = url('/donate');
        }

        return static::ensureLiveHttpsScheme($url);
    }

    /**
     * Ensure HTTP is upgraded to HTTPS for live domain hosting environments.
     */
    protected static function ensureLiveHttpsScheme(string $url): string
    {
        $parsed = parse_url($url);
        $host = $parsed['host'] ?? '';

        // Check if environment is live server (not localhost/local testing IP)
        $isLocalHost = in_array(strtolower($host), ['localhost', '127.0.0.1', '::1', 'localhost:8000', 'localhost:8001'])
            || str_ends_with(strtolower($host), '.test')
            || str_ends_with(strtolower($host), '.local');

        // On live domains, enforce HTTPS scheme if reverse proxy or APP_URL evaluated to http
        if (!$isLocalHost && str_starts_with($url, 'http://')) {
            $url = 'https://' . substr($url, 7);
        }

        // Respect X-Forwarded-Proto header if present on live server
        if (request()->header('X-Forwarded-Proto') === 'https' && str_starts_with($url, 'http://')) {
            $url = 'https://' . substr($url, 7);
        }

        return $url;
    }
}
