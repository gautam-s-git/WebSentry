<?php

namespace App\Observers;

use App\Models\Website;
use App\Services\MonitoringService;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class WebsiteObserver
{
    /**
     * Handle the Website "created" event.
     */
   /**
     * Handle the Website "created" event.
     */
    public function created(Website $website): void
    {


        // Call the static method with required parameters
        MonitoringService::checkWebsiteStatus(
            $website->url,
            $website->client_id,
            $website->id
        );
    }

    /**
     * Handle the Website "updated" event.
     */
    public function updated(Website $website): void
    {
        //
    }

    /**
     * Handle the Website "deleted" event.
     */
    public function deleted(Website $website): void
    {
        //
    }

    /**
     * Handle the Website "restored" event.
     */
    public function restored(Website $website): void
    {
        //
    }

    /**
     * Handle the Website "force deleted" event.
     */
    public function forceDeleted(Website $website): void
    {
        //
    }
}
