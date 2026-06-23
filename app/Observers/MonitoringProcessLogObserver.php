<?php

namespace App\Observers;

use App\Models\MonitoringProcessLog;

use App\Services\MailNotificationService;


class MonitoringProcessLogObserver
{
    /**
     * Handle the MonitoringProcessLog "created" event.
     */
    public function created(MonitoringProcessLog $monitoringProcessLog): void
    {
        // Notify client on both down and recovery (up) events
        if (in_array($monitoringProcessLog->status, ['down', 'up'])) {
            $client = $monitoringProcessLog->client;
            MailNotificationService::notifyClient($client, $monitoringProcessLog);
        }
    }

    /**
     * Handle the MonitoringProcessLog "updated" event.
     */
    public function updated(MonitoringProcessLog $monitoringProcessLog): void
    {
        //
    }

    /**
     * Handle the MonitoringProcessLog "deleted" event.
     */
    public function deleted(MonitoringProcessLog $monitoringProcessLog): void
    {
        //
    }

    /**
     * Handle the MonitoringProcessLog "restored" event.
     */
    public function restored(MonitoringProcessLog $monitoringProcessLog): void
    {
        //
    }

    /**
     * Handle the MonitoringProcessLog "force deleted" event.
     */
    public function forceDeleted(MonitoringProcessLog $monitoringProcessLog): void
    {
        //
    }
}
