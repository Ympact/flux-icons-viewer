<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeIconVendors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux-icons:purge-icon-vendors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all build icons from the vendors.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // using the flux-icons config, get the list of vendors
        // remove the icons from /resources/views/flux/{vendor}
        // remove the packages from node_modules and npm package.json

        $vendors = config('flux-icons.vendors');
        foreach ($vendors as $vendor => $vendorDetails) {
            $this->purgeVendor($vendor, $vendorDetails);
        }
    }

    private function purgeVendor($vendor, $vendorDetails)
    {
        $this->info("Purging $vendor icons...");
        $this->purgeVendorFiles($vendor, $vendorDetails);
        $this->purgeVendorPackages($vendor, $vendorDetails);
    }

    private function purgeVendorFiles($vendor, $vendorDetails)
    {
        // blade files
        $vendorPath = resource_path("views/flux/icon/$vendor");
        if (file_exists($vendorPath)) {
            $this->info("Removing $vendor icons from $vendorPath...");
            exec("rm -rf $vendorPath");
        }

        // service files
        $vendorPath = app_path("Services/FluxIcons/Vendors/$vendor");
        if (file_exists($vendorPath)) {
            $this->info("Removing $vendor service files from $vendorPath...");
            exec("rm -rf $vendorPath");
        }
    }

    private function purgeVendorPackages($vendor, $vendorDetails)
    {
        $vendorPackage = $vendorDetails['package'];
        $this->info("Removing $vendor package from node_modules...");
        exec("npm uninstall $vendorPackage");
    }
}
