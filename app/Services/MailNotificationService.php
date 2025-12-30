<?php

namespace App\Services;

use App\Models\MonitoringProcessLog;
use App\Models\MailNotificationLog;
use App\Notifications\MonitoringProcessNotification;
use Exception;
use Illuminate\Support\Facades\Notification;

class MailNotificationService
{
    public static function notifyClient($client, $monitoringProcessLog)
    {
        $isDelivered = false;
        $failureMessage = null;
        $emailSubject = '🔴 Website Down Alert - ' . $monitoringProcessLog->website->name;
        $emailMessage = 'Your website ' . $monitoringProcessLog->website->name . ' is currently DOWN.';

        try {
            // Send notification immediately
            Notification::sendNow($client, new MonitoringProcessNotification($monitoringProcessLog));

            $isDelivered = true;

        } catch (Exception $e) {
            $isDelivered = false;
            $failureMessage = $e->getMessage();
        }

        // Log email notification to database
        MailNotificationLog::create([
            'client_id' => $client->id,
            'email' => $client->email,
            'website_id' => $monitoringProcessLog->website_id,
            'email_sent_on' => now(),
            'is_delivered' => $isDelivered,
            'failure_message' => $failureMessage,
            'email_message' => $emailMessage,
            'email_subject' => $emailSubject,
            'notification_type' => $monitoringProcessLog->status == 'down' ? 'down' : 'up',
        ]);

        return $isDelivered;
    }
}
