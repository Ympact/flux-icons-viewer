<?php

namespace Ympact\FluxMarkDown;

use Illuminate\Support\ServiceProvider;

class FluxMarkDownServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge the package configuration with the application's copy.
        $this->mergeConfigFrom(__DIR__.'/../config/flux-markdown.php', 'flux-markdown');
    }

    public function boot(): void
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/../config/flux-markdown.php' => config_path('flux-markdown.php'),
        ], 'flux-markdown-config');

        // Register the commands
        $this->bootCommands();


    }
    
    public function bootCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        /*
        $this->commands([
            Console\BuildFluxMarkDownCommand::class,
            Console\PublishFluxMarkDownVendorFileCommmand::class,
        ]);
        */
    }
}