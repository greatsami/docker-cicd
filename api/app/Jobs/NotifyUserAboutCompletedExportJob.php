<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ExportCompletedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserAboutCompletedExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User             $user,
        private readonly string $fileLink,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(new ExportCompletedNotification($this->fileLink));
    }
}
