<?php

use App\Console\Commands\PingFreeCommand;
use App\Console\Commands\UpdateActionsCommand;
use App\Console\Commands\UpdateStatsRecentCommand;
use Illuminate\Support\Facades\Schedule;

// site status
Schedule::command(PingFreeCommand::class)->hourly()->withoutOverlapping()->evenInMaintenanceMode();

// count user actions for all sites (pageviews and events)
Schedule::command(UpdateActionsCommand::class)->everySixHours();

// update recent stats table (used in charts)
Schedule::command(UpdateStatsRecentCommand::class)->everyThreeHours();
