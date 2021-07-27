## monica
```php
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleCommand($schedule, 'send:reminders', 'hourly');
        $this->scheduleCommand($schedule, 'send:stay_in_touch', 'hourly');
        $this->scheduleCommand($schedule, 'monica:calculatestatistics', 'daily');
        $this->scheduleCommand($schedule, 'monica:ping', 'daily');
        $this->scheduleCommand($schedule, 'monica:clean', 'daily');
        $this->scheduleCommand($schedule, 'monica:updategravatars', 'weekly');
        if (config('trustedproxy.cloudflare')) {
            $this->scheduleCommand($schedule, 'cloudflare:reload', 'daily'); // @codeCoverageIgnore
        }
    }

    /**
     * Define a new schedule command with a frequency.
     */
    private function scheduleCommand(Schedule $schedule, string $command, $frequency)
    {
        $schedule->command($command)->when(function () use ($command, $frequency) {
            $event = CronEvent::command($command); // @codeCoverageIgnore
            if ($frequency) { // @codeCoverageIgnore
                $event = $event->$frequency(); // @codeCoverageIgnore
            }

            return $event->isDue(); // @codeCoverageIgnore
        });
    }
```








_____________________________________________________________
october\modules\system\ServiceProvider.php

    /**
     * Register command line specifics
     */
    protected function registerConsole()
    {
        /*
         * Allow plugins to use the scheduler
         */
        Event::listen('console.schedule', function ($schedule) {
            // Fix initial system migration with plugins that use settings for scheduling - see #3208
            if (App::hasDatabase() && !Schema::hasTable(UpdateManager::instance()->    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleCommand($schedule, 'send:reminders', 'hourly');
        $this->scheduleCommand($schedule, 'send:stay_in_touch', 'hourly');
        $this->scheduleCommand($schedule, 'monica:calculatestatistics', 'daily');
        $this->scheduleCommand($schedule, 'monica:ping', 'daily');
        $this->scheduleCommand($schedule, 'monica:clean', 'daily');
        $this->scheduleCommand($schedule, 'monica:updategravatars', 'weekly');
        if (config('trustedproxy.cloudflare')) {
            $this->scheduleCommand($schedule, 'cloudflare:reload', 'daily'); // @codeCoverageIgnore
        }
    }

    /**
     * Define a new schedule command with a frequency.
     */
    private function scheduleCommand(Schedule $schedule, string $command, $frequency)
    {
        $schedule->command($command)->when(function () use ($command, $frequency) {
            $event = CronEvent::command($command); // @codeCoverageIgnore
            if ($frequency) { // @codeCoverageIgnore
                $event = $event->$frequency(); // @codeCoverageIgnore
            }

            return $event->isDue(); // @codeCoverageIgnore
        });
    }getMigrationTableName())) {
                return;
            }

            $plugins = PluginManager::instance()->getPlugins();
            foreach ($plugins as $plugin) {
                if (method_exists($plugin, 'registerSchedule')) {
                    $plugin->registerSchedule($schedule);
                }
            }
        });




________________________________________________________________
monica\tests\Unit\Helpers\AccountHelperTest.php

        // add 3 reminders for the month of March
        for ($i = 0; $i < 3; $i++) {
            $reminder = factory(Reminder::class)->create([
                'account_id' => $account->id,
                'initial_date' => '2017-03-03 00:00:00',
            ]);

            $reminder->schedule($user);
        }




monica\database\migrations\2019_05_05_194746_add_cron_schedule.php


```php
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleCommand($schedule, 'send:reminders', 'hourly');
        $this->scheduleCommand($schedule, 'send:stay_in_touch', 'hourly');
        $this->scheduleCommand($schedule, 'monica:calculatestatistics', 'daily');
        $this->scheduleCommand($schedule, 'monica:ping', 'daily');
        $this->scheduleCommand($schedule, 'monica:clean', 'daily');
        $this->scheduleCommand($schedule, 'monica:updategravatars', 'weekly');
        if (config('trustedproxy.cloudflare')) {
            $this->scheduleCommand($schedule, 'cloudflare:reload', 'daily'); // @codeCoverageIgnore
        }
    }
```

