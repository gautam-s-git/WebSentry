<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\MonitoringProcessLog;
use Exception;

class MonitoringService
{
    public static function checkWebsiteStatus($url, $clientId, $websiteId)
    {
        $isActive = false;
        $statusCode = null;
        $responseTime = null;
        $failureError = null;
        $responseBody = null;

        try {
            $startTime = microtime(true);

            $response = Http::timeout(10)->get($url);

            $endTime = microtime(true);
            $responseTime = round(($endTime - $startTime) * 1000); // milliseconds

            $statusCode = $response->status();
            $isActive = $response->successful(); // true if 2xx status

            if (!$isActive) {
                $failureError = "HTTP Error: Status code {$statusCode}";
                $responseBody = $response->body();
            }

        } catch (Exception $e) {
            $isActive = false;
            $failureError = $e->getMessage();
            $statusCode = 0;
        }

        // Insert into database
       MonitoringProcessLog::create([
            'client_id' => $clientId,
            'website_id' => $websiteId,
            'last_monitored' => now(),
            'status' => $isActive ? 'up' : 'down',
            'status_code' => $statusCode,
            'response_time' => $responseTime,
            'failure_error' => $failureError,
            'response_body' => $responseBody,
        ]);





        return $isActive;
    }
}
