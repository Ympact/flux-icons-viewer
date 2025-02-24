<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalyzeIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux-icons:analyze {vendor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze the icons of a specific vendor and list the icons that might need to be added to the config.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $noInteraction = $this->option('no-interaction');
        $verbose = $this->option('verbose');
        $vendor = $this->argument('vendor');

        // read all files from node_modules/vendor file: get this file from the config
        $vendorDetails = config("flux-icons.vendors.$vendor");
        $vendorPackage = $vendorDetails['package'];
        $vendorPath = base_path("node_modules/$vendorPackage");

        if (!file_exists($vendorPath)) {
            $this->error("Vendor package $vendorPackage not found in node_modules.");
            return 1;
        }



    }

}

