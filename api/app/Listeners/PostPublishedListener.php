<?php

namespace App\Listeners;

use App\Events\PostPublishedEvent;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostPublishedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PostPublishedEvent $event): void
    {
        User::query()->where('id', $event->post->author->id)
            ->get()
            ->each
            ->notify(
                (new PostPublishedNotification($event->post))->onQueue('notifications')
            );
    }
}
