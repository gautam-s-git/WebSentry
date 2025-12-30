<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website; // Make sure to import the Website model

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = self::getWebsiteList();

        // Use create() instead of insert() to trigger observer
        foreach ($websites as $website) {
            Website::create($website);
        }
    }

    private static function getWebsiteList()
    {
        $websites = [
            // Client 1 - John Doe (4 websites)
            ['client_id' => 1, 'url' => 'https://www.google.com', 'name' => 'Google', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 1, 'url' => 'https://www.github.com', 'name' => 'GitHub', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 1, 'url' => 'https://www.stackoverflow.com', 'name' => 'Stack Overflow', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 1, 'url' => 'https://www.laravel.com', 'name' => 'Laravel', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Client 2 - Jane Smith (4 websites)
            ['client_id' => 2, 'url' => 'https://www.wikipedia.org', 'name' => 'Wikipedia', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 2, 'url' => 'https://www.twitter.com', 'name' => 'Twitter', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 2, 'url' => 'https://www.facebook.com', 'name' => 'Facebook', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 2, 'url' => 'https://www.youtube.com', 'name' => 'YouTube', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Client 3 - Bob Johnson (4 websites)
            ['client_id' => 3, 'url' => 'https://www.amazon.com', 'name' => 'Amazon', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 3, 'url' => 'https://www.reddit.com', 'name' => 'Reddit', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 3, 'url' => 'https://www.linkedin.com', 'name' => 'LinkedIn', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['client_id' => 3, 'url' => 'https://www.netflix.com', 'name' => 'Netflix', 'active' => 1, 'check_interval' => 5, 'created_at' => now(), 'updated_at' => now()],
        ];

        return $websites;
    }
}
