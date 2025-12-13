<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Announcement;
use App\Http\Controllers\AnnouncementController;

class NotifySubscribers extends Command
{
    protected $signature = 'notify:subscribers';
    protected $description = 'Send announcement notifications on publish date';

    public function handle()
    {
        $today = now()->toDateString();

        $announcements = Announcement::whereDate('published_at', $today)
            ->where('is_active', true)
            ->whereNull('notified_at')
            ->get();

        $controller = new AnnouncementController;

        foreach ($announcements as $announcement) {
            $controller->notifySubscribers($announcement);
        }

        $this->info('Notifications sent for today\'s announcements.');
    }
}
