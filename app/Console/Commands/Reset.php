<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux-icons:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove custom config file and all built icons from vendors.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // call the PurgeIconVendors command
        $this->call('flux-icons:purge-icon-vendors');

        // in case we have a published config file we remove it
        $configPath = config_path('flux-icons.php');
        if (file_exists($configPath)) {
            $this->info('Removing flux-icons config...');
            unlink($configPath);
        }
    }
}