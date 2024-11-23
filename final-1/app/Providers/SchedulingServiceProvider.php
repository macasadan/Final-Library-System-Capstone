<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\DiscussionRoom;
use App\Models\DiscussionRoomReservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Cache\Factory as Cache;

class SchedulingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Schedule::class, function ($app) {
            return new Schedule($app[Cache::class]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->app->resolving(Schedule::class, function ($schedule) {
                $this->schedule($schedule);
            });
        }
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        try {
            // Check expired reservations every minute
            $schedule->command('reservations:check-expired')->everyMinute();

            // Update room statuses every minute using closure
            $schedule->call(function () {
                $this->updateRoomStatuses();
            })->everyMinute();
        } catch (\Exception $e) {
            Log::error('Scheduling error: ' . $e->getMessage());
        }
    }

    /**
     * Update room statuses and handle reservations
     */
    protected function updateRoomStatuses(): void
    {
        try {
            // Mark expired reservations
            DiscussionRoomReservation::query()
                ->where('status', 'approved')
                ->where('end_time', '<', now())
                ->update(['status' => 'expired']);

            // Get rooms with active reservations
            $rooms = DiscussionRoom::with(['reservations' => function ($query) {
                $query->where('status', 'approved')
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>', now());
            }])->get();

            // Log room statuses
            foreach ($rooms as $room) {
                Log::info("Room {$room->name} status check - " . now()->toDateTimeString());
                Log::info("Current availability: {$room->availability_status}");

                $currentReservation = $room->getCurrentReservation();
                if ($currentReservation) {
                    Log::info("Active reservation found - Ends at: {$currentReservation->end_time}");
                }
            }
        } catch (\Exception $e) {
            Log::error('Room status update error: ' . $e->getMessage());
        }
    }
}
