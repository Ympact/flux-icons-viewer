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