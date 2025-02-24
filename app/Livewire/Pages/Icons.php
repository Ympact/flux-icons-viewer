<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Ympact\FluxIcons\Services\IconBuilder;


class Icons extends Component
{

    #[Url]
    public $vendor;

    public $query = '';

    public $variant;

    public $vendors;

    public array $variants;

    public array $files;

    public Collection $iconNames;
    
    public $pagination = 30;

    #[Url]
    public $page = 1;

    public $iconModal = false;
     
    public $selectedIcon;

    public $orginalIcon = '';

    public function mount()
    {
        $this->vendors = IconBuilder::getAvailableVendors()->mapWithKeys(function($vendor, $key){
            return [$key => $vendor['vendor_name']];
        });

        // set the first vendor as the default
        $this->vendor = $this->vendors->keys()->first();

        $this->variants = [
            'outline' => 'Outline',
            'solid' => 'Solid',
            'mini' => 'Mini',
            'micro' => 'Micro',
        ];

        // set the first variant as the default
        $this->variant = array_keys($this->variants)[0];

        $this->findIcons();
    }

    public function showIconModal($icon){
        $this->selectedIcon = $icon;
        // get the original icon from the vendor:
        // lets use flux-icons config to get node_modules path
        $vendorDetails = config("flux-icons.vendors.$this->vendor");
        $vendorPackage = $vendorDetails['package'];
        $vendorPath = base_path("node_modules/$vendorPackage");

        // determine the outline variant file based on variants config:
        $sourceConfig = $vendorDetails['variants']['outline']['source'];
        if(is_array($sourceConfig)){
            // dir, suffix, prefix
            $file = Str::of($sourceConfig['dir'])
                ->append('/')
                ->append($sourceConfig['prefix'] ?? '')
                ->append($icon)
                ->append($sourceConfig['suffix'] ?? '')
                ->finish('.svg');
        }
        else{
            $file = Str::of($sourceConfig)->append('/')->append($icon)->finish('.svg');
        }
        if(file_exists(base_path($file))){
            $this->orginalIcon = File::get(base_path($file));
        }
        else{
            $this->orginalIcon = 'Icon not found';
        }

        $this->iconModal = true;
    }

    public function closeIconModal(){
        $this->iconModal = false;
    }


    #[Computed]
    public function icons(){
        if($this->iconNames->isNotEmpty()){
            return $this->iconNames->chunk($this->pagination)[$this->page - 1];
        }
        else{
            return collect([]);
        }
    }

    #[Computed]
    public function iconCount(){
        return $this->iconNames->count();
    }

    // get page count
    #[Computed]
    public function pageCount(){
        return (int) ceil($this->iconCount() / $this->pagination);
    }

    public function previousPage(){
        if($this->page > 1){
            $this->page--;
        }
    }

    public function nextPage(){
        if($this->page < $this->pageCount){
            $this->page++;
        }
    }

    public function findIcons(){
        $vendorDir = IconBuilder::getAvailableVendors()->get($this->vendor)['namespace'] ;

        $this->files[$this->vendor] = File::glob(
            Str::of(resource_path('views/flux/icon/'. $vendorDir ))->append('/*')->finish('.blade.php')
        );
        // get the filenames
        $this->iconNames = collect($this->files[$this->vendor])->map(function($file){
            return [
                'icon' => Str::of(pathinfo($file, PATHINFO_FILENAME))->replace('.blade', '')->toString(),
                'lev' => 0
            ];
        });

    }

    public function updatedQuery(){
        if(strlen($this->query) > 2){
            // reset the page
            $this->page = 1;
            $this->search();
        }
        if(strlen($this->query) == 0){
            // reset the page
            $this->page = 1;
            $this->resetSearch();
        }

    }

    public function resetSearch(){
        $this->iconNames = collect($this->files[$this->vendor])->map(function($file){
            return [
                'icon' => Str::of(pathinfo($file, PATHINFO_FILENAME))->replace('.blade', '')->toString(),
                'lev' => 0
            ];
        });
    }

    public function search(){
        // loop through words to find the closest
        $this->iconNames = $this->iconNames->map( function($icon){

            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($this->query, $icon['icon']);
            // add lev to the array
            return ['icon' => $icon['icon'], 'lev' => $lev];
            
        })->filter(function($icon){
            // filter out the words that are too far away
            return $icon['lev'] < 3;
        })->sortBy('lev');
    }

    public function getNamespace($vendor = null){
        $vendor = $vendor ?? $this->vendor;
        return IconBuilder::getAvailableVendors()->get($vendor)['namespace'];
    }

    public function getVendorName($vendor = null){
        $vendor = $vendor ?? $this->vendor;
        return IconBuilder::getAvailableVendors()->get($vendor)['vendor_name'];
    }

    public function updatedVendor($vendor)
    {
        $this->page = 1;
        $this->findIcons();
    }

}