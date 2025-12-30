<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Services\MonitoringService;
use App\Events\WebsiteDownEvent;

class MonitorWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:websites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor all active websites and check their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting website monitoring...');

        $websites = Website::with('client')
            ->where('active', 1) // Only monitor active websites
            ->orderBy('id', 'DESC')
            ->get();

        $this->info("Found {$websites->count()} websites to monitor.");

        foreach ($websites as $website) {
            $this->info("Checking: {$website->name} ({$website->url})");

            $url = $website->url;
            $clientId = $website->client->id;
            $websiteId = $website->id;

            // Check website status
            $isUp = MonitoringService::checkWebsiteStatus($url, $clientId, $websiteId);

            if (!$isUp) {
                $this->error("⚠️  {$website->name} is DOWN!");

                // Broadcast event when website is down
                event(new WebsiteDownEvent($website, $website->client));
            } else {
                $this->info("✓ {$website->name} is UP");
            }
        }

        $this->info('Website monitoring completed!');

        return Command::SUCCESS;
    }
}
