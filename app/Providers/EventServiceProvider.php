<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\JobApplicationStatusChanged;
use App\Events\JobApplicationWithdrawn;
use App\Events\JobVacancyCreated;
use App\Listeners\SendApplicationStatusNotification;
use App\Listeners\SendApplicationWithdrawNotification;
use App\Listeners\SendJobMatchNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        JobApplicationStatusChanged::class => [
            SendApplicationStatusNotification::class,
        ],
        JobApplicationWithdrawn::class => [
            SendApplicationWithdrawNotification::class,
        ],
        JobVacancyCreated::class => [
            SendJobMatchNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
