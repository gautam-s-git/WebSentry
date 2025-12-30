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

      if($monitoringProcessLog->status == 'down') {

          // Get the client/user who owns this website
        $client = $monitoringProcessLog->client;

        MailNotificationService::notifyClient($client,$monitoringProcessLog);

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
