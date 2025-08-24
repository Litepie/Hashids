<?php

declare(strict_types=1);

namespace Litepie\Hashids;

use Sqids\Sqids;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HashidsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/hashids.php', 'hashids');

        // Bind 'hashids' shared component to the IoC container
        $this->app->singleton('hashids', function (Application $app): Sqids {
            // Read settings from config file
            $config = $app->config->get('hashids', []);

            $alphabet = $config['alphabet'] ?? Sqids::DEFAULT_ALPHABET;
            $minLength = $config['length'] ?? Sqids::DEFAULT_MIN_LENGTH;
            $blocklist = $config['blocklist'] ?? Sqids::DEFAULT_BLOCKLIST;

            return new Sqids($alphabet, $minLength, $blocklist);
        });

        // Register alias
        $this->app->alias('hashids', Sqids::class);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/hashids.php' => config_path('hashids.php'),
            ], 'hashids-config');
            
            $this->publishes([
                __DIR__.'/../config/hashids.php' => config_path('hashids.php'),
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return ['hashids'];
    }
}
