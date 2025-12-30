<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Website;
use App\Models\User;

class WebsiteDownEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $website;
    public $client;
    public $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct(Website $website, User $client)
    {
        $this->website = [
            'id' => $website->id,
            'name' => $website->name,
            'url' => $website->url,
            'status' => $website->status ?? 'down',
        ];

        $this->client = [
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
        ];

        $this->timestamp = now()->toDateTimeString();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('website-monitoring'),
            new PrivateChannel('client.' . $this->client['id']),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'website.down';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'website' => $this->website,
            'client' => $this->client,
            'timestamp' => $this->timestamp,
            'message' => "Website {$this->website['name']} is currently down!",
        ];
    }
}
