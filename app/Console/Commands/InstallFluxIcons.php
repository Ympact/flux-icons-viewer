<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallFluxIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux-icons:install-examples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the flux-icons examples.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // we publish the config for flux-icons
        // add the following icons to the $icons array
        // ['tabler' => ['home', 'confetti', 'windmill', 'icons', 'brand-github', 'info-square-rounded', 'moon', 'sun', 'filter', 'refresh', 'chevron-right', 'chevron-left']]

        $this->info('Publishing flux-icons config...');
        $this->call('vendor:publish', [
            '--tag' => 'flux-icons-config'
        ]);

        $this->info('Adding icons to config...');
        $this->addIconsToConfig();

        $this->info('build the icons');
        $this->call('flux-icons:build', [
            'vendor' => 'tabler',
            '--no-interaction' => true,
        ]);

    }

    private function addIconsToConfig()
    {
        $configPath = config_path('flux-icons.php');
        $config = require $configPath;

        $config['icons'] = [
            'tabler' => ['home', 'confetti', 'windmill', 'icons', 'brand-github', 'info-square-rounded', 'moon', 'sun', 'filter', 'refresh', 'chevron-right', 'chevron-left']
        ];

        file_put_contents($configPath, '<?php return ' . var_export($config, true) . ';');

        // after adjusting the config, we need to refresh it
        $this->info('Reset cache...');
        $this->call('config:cache');
        $this->call('config:clear');

    }
}
