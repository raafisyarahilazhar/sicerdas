<?php

namespace App\Services;

use App\Models\Application;
use App\Jobs\SendFonnteNotification;

class NotificationService
{
    public function sendSuratSelesaiNotification(Application $application): void
    {
        SendFonnteNotification::dispatch($application->id);
    }
}

