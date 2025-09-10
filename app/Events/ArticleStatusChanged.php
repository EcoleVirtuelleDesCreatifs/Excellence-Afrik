<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;

class ArticleStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Article $article;
    public string $oldStatus;
    public string $newStatus;
    public ?string $reason;

    /**
     * Create a new event instance.
     */
    public function __construct(Article $article, string $oldStatus, string $newStatus, ?string $reason = null)
    {
        $this->article = $article;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
