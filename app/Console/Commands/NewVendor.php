<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\ask;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;
use function Laravel\Prompts\table;

class NewVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux-icons:new {npm-package?}';

    protected $commonNaming = [
        'outline' => ['outline'],
        'solid' => ['solid', 'filled'],
    ];

    protected Collection $svgDirectories;
    protected Collection $svgFiles;

    protected $resultConfig = [
        'vendor_name' => '',
        'namespace' => '',
        'package' => '',
        'baseVariant' => 'outline',
        'variants' => [],
        'transform' => null, 
        'stroke_width' => null,
        'attributes' => null,
    ];

    protected $sourceConfig = [
        'dir' => '',
        'prefix' => null,
        'suffix' => null,
        'filter' => null
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Try to add a new vendor to the config.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $noInteraction = $this->option('no-interaction');
        $verbose = $this->option('verbose');

        $package = $this->argument('npm-package') ?? $this->ask('What is the npm package name of the vendor?');

        // check if the package is already present in the config
        $vendors = collect(config('flux-icons.vendors'));
        if ($vendors->pluck('package')->contains($package)) {
            $packageKey = $vendors->where('package', $package)->keys()->first();
            $this->error("$package is already configured in the config. To use it run `flux-icons:build {$packageKey}`");
            $this->newLine();
            return 1;
        }

        $packageDetails = json_decode(shell_exec("npm show $package --json --silent"), true);
        if(key_exists( 'error',$packageDetails)){
            $this->error("An error occured when looking for $package: ");
            $this->error($packageDetails['error']['detail']);
            //$this->error($packageDetails->first()['error']['detail']);
            return 1;
        }


        info("Package details");
        $seledctedDetails = collect([$packageDetails])->select(['name', 'version', 'author', 'description', 'license'])->first();
        table(array_keys($seledctedDetails), [array_values($seledctedDetails)]);

        $vendorName = $this->determineVendorName($packageDetails);
        $vendorName = text('Enter the vendor name for the package in Title Case', 'Vendor Name', $vendorName);
        
        $this->resultConfig =[
            'vendor_name' => $vendorName,
            'namespace' => Str::slug($vendorName),
            'package' => $package
        ];
        
        // confirm if the user wants to add the package
        if (!$noInteraction && !confirm("Do you want to add $package to the config?")) {
            return 0;
        }
        // let's try to install the package
        $this->info("Trying to install $package...");
        exec("npm install $package", $installPackageOutput, $installPackageResult);
        if($installPackageResult === 128){
            $this->error("An error occured when trying to install $package: ");
            $this->error($installPackageOutput);
            return 1;
        }
        $this->info($installPackageResult);


        // find all the directories within the package that contain svg icons
        $packagePath = base_path("node_modules/$package");
        $this->info("Trying to find all icons within $packagePath");
        $this->getSvgs($packagePath);

        // try to determine which files are outline and which are filled
        // in case we have multiple directories, lets ask the user which directory is outline, which is filled or whether we should try to determine it automatically
        if(count($this->svgDirectories) > 1){
            //dump($this->svgDirectories);
            $svgDirectoriesOptions = $this->svgDirectories->pluck('toplevel_dir', 'base_dir')
                ->put('auto', 'None, or can\'t tell, analyse icons to determine.')
                ->toArray();
            
            // try to automagically determine which directory contains outline icons and which contains filled/solid icons to set the default for the select
            $suggestedOutlineDirectory = $this->svgDirectories->filter(function($directory){
                // first check if the name of the directory contains any of the commonNaming['outline'] words
                return collect($this->commonNaming['outline'])->contains(function($word) use ($directory){
                    return strpos($directory['toplevel_dir'], $word) !== false;
                });

            })->pluck('base_dir')->first();

            $outlineDirectory = select("Select the directory that contains outline icons", $svgDirectoriesOptions, $suggestedOutlineDirectory);
           
            $suggestedSolidDirectory = $this->svgDirectories->filter(function($directory) {
                // first check if the name of the directory contains  any of the commonNaming['solid'] words
                $res = collect($this->commonNaming['solid'])->contains(function($word) use ($directory){
                    return strpos($directory['toplevel_dir'], $word) !== false;
                });
                return $res;
            })->pluck('base_dir')->first();

            $solidDirectory = select("Select the directory that contains solid/filled icons", $svgDirectoriesOptions, $suggestedSolidDirectory);
            
            if($outlineDirectory == $solidDirectory){
                // lets analyse the icons which files are outline and which are solid
                // do they have a prefix or suffix?
                // they have the fill="none" attribute?

                $this->info("Analyzing the icons to determine which files are outline and which are solid...");
                // test for outline,solid,filled as prefix or suffix in the icon names
                $prefices = collect();
                $suffices = collect();
                $unknowns = collect();
                
                $this->svgFiles->each(function($file, $directory) use (&$prefices, &$suffices){
                    /**
                     * @var \Symfony\Component\Finder\SplFileInfo $file
                     */
                    $iconName = pathinfo($file, PATHINFO_FILENAME);

                    foreach($this->commonNaming as $key => $naming){
                        if(Str::startsWith($iconName, $naming)){
                            // determine actual prefix
                            $prefix = collect($naming)->filter(function($word) use ($iconName){
                                return strpos($iconName, $word) !== false;
                            })->first();
                            // determine optional delimiter
                            $delimiters = ['-','_'];
                            $delimiter = collect($delimiters)->filter(function($delimiter) use ($iconName, $prefix){
                                return strpos($iconName, $prefix . $delimiter) !== false;
                            })->first();

                            if(!$prefices->has($key)){
                                $prefices->put($key, collect([
                                        'prefix' => collect(),
                                        'files' => collect()
                                    ])
                                );
                            }
                            
                            $prefix . $delimiter;
                            $prefices[$key]['files']->put($iconName, [Str::of($iconName)->remove($prefix . $delimiter)]);
                            
                            // end the foreach loop
                            continue;
                        }
                        if(Str::endsWith($iconName, $naming)){
                            // determine actual suffix
                            $suffix = collect($naming)->filter(function($word) use ($iconName){
                                return strpos($iconName, $word) !== false;
                            })->first();
                            // determine optional delimiter
                            $delimiters = ['-','_'];
                            $delimiter = collect($delimiters)->filter(function($delimiter) use ($iconName, $suffix){
                                return strpos($iconName, $delimiter . $suffix) !== false;
                            })->first();

                            //dump($key, $file->getFilename(), $iconName, $suffix, $delimiter);

                            $suffices[$key] = collect([$file->getFilename() => [Str::before($iconName, $delimiter . $suffix)]]);
                            continue;
                        }

                        $unknowns = collect([$file->getFilename() => [$iconName]]);
                    }
                });
                dump($suffices, $prefices);
            }
            else{
                // determine if we need to add */ to the directories based on the level
                $outlineDirDetails = $this->svgDirectories->where('base_dir',$outlineDirectory)->first();
                if($outlineDirDetails['level'] > 0){
                    $this->resultConfig['outline']['source'] = Str::of($outlineDirDetails['base_dir'] . Str::repeat('/*', $outlineDirDetails['level']))->finish('/')->toString();
                }
                else{
                    $this->resultConfig['outline']['source'] = Str::of($outlineDirDetails['base_dir'])->finish('/')->toString();
                }
                
                // determine if we need to add */ to the directories based on the level
                $solidDirDetails = $this->svgDirectories->where('base_dir',$solidDirectory)->first();
                if($solidDirDetails['level'] > 0){
                    ;
                    $this->resultConfig['solid']['source'] = Str::of($solidDirDetails['base_dir'] . Str::repeat('/*', $solidDirDetails['level']))->finish('/')->toString();
                }
                else{
                    $this->resultConfig['solid']['source'] = Str::of($solidDirDetails['base_dir'])->finish('/')->toString();
                }
            }

            // we probably need create a filter function to determine if the icon is an outline icon
            if( $outlineDirectory === 'auto' ){
                // then check if any of the files contain the fill="none" attribute
                return $this->svgFiles->filter(function($file){
                    return strpos(file_get_contents($file), 'fill="none"') !== false;
                })->count() > 0;
            }

            if( $solidDirectory === 'auto' ){
                // then check if any of the files contain the fill="none" attribute
                return $this->svgFiles->filter(function($file){
                    return strpos(file_get_contents($file), 'fill="none"') === false;
                })->count() > 0;
            }

            // write $this->resultConfig as php array in console to be copied to the config
            $this->info("Add the following to the config:");
            dump($this->resultConfig);
        }
    }

    private function determineVendorName(array $packageDetails): string
    {
        $vendorName = Str::of($packageDetails['name'])
            ->remove('@')
            ->remove('-icons')
            ->remove('/')
            ->remove('svg')
            ->title();
        return $vendorName;
    }

    private function getSvgs($packagePath): void
    {
        $this->svgFiles = collect(File::allFiles($packagePath))->filter(function ($file) {
            return $file->getExtension() === 'svg';
        });
        
        $this->svgDirectories = $this->getDirs($packagePath);

        // sort svgDirectories by the number of dirs in path
        $this->svgDirectories = $this->svgDirectories->sortBy(function(array $dir){
            return substr_count($dir['toplevel_dir'], '/');
        });
        
    }

    private function getDirs($packagePath, Collection|null $dirs = null, $level = 0) : Collection
    {
        if($dirs === null){
            $dirs = $this->svgFiles->map(function($file){
                return pathinfo($file->getPathname(), PATHINFO_DIRNAME);
            })->unique();
        }

        $dirs = $dirs->mapWithKeys(function($dir) use ($packagePath, $level){
            $toplevel = Str::after($dir, $packagePath);
            $baseDir = Str::of($dir)->after('node_modules')->start('node_modules')->toString();
            return [
                $toplevel => [
                    'full_dir' => $dir,
                    'base_dir' => $baseDir, 
                    'toplevel_dir' => $toplevel,
                    'level' => $level,
                    //'files' => $this->svgFiles->filter(function($file) use ($dir){
                    //    return Str::startsWith($file, $dir);
                    //})
                ]
            ];
        });

        // if more than 2 directories, also include the parent directory
        if($dirs->count() > 2){ 
            // get the parent directories
            $parents = $dirs->map(function($dir){
                return dirname($dir['full_dir']);
            })->unique();
            $parentDirs = $this->getDirs($packagePath, $parents, $level+1 );
            $dirs = $dirs->merge($parentDirs)->unique();
        }
        return $dirs;
    }

}

