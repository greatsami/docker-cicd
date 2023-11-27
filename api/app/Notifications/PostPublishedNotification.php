<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    public function backoff(): array
    {
        return [30, 60, 120];
    }

    public function __construct(
        private readonly Post $post
    ) {
    }

    /**
     * @return string[]
     */
    public function via(): array
    {
        return ['mail', 'database'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->line('A new post for you!')
            ->line("There is a new post for you: {$this->post->title}")
            ->action('Read more', route('posts.show', ['post' => $this->post]));
    }

    public function toArray(): array
    {
        return [
            'title' => 'A new post for you!',
            'body' => "There is a new post for you: {$this->post->title}",
            'link' => route('posts.show', ['post' => $this->post]),
        ];
    }
}
