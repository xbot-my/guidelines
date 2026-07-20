<?php

namespace XBot\Guidelines;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class GuidelinesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    /**
     * Override base path for boost:* commands so they see the package root
     * instead of Testbench's bundled Laravel app.
     */
    public function register(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        /** @var string $packageRoot */
        $packageRoot = realpath(__DIR__.'/..');

        Event::listen(CommandStarting::class, function (CommandStarting $event) use ($packageRoot): void {
            if (! str_starts_with($event->command, 'boost:')) {
                return;
            }

            $this->app->setBasePath($packageRoot);
        });
    }
}
