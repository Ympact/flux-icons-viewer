<?php

namespace App\Livewire\Filters;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Ympact\FluxIcons\Services\IconBuilder;

class Vendor extends Component
{
    #[Modelable]
    public $vendor;

    public $vendors;

    public function mount()
    {
        $this->vendors = IconBuilder::getAvailableVendors()->mapWithKeys(function($vendor){
            return $vendor['vendor_name'];
        });
    }
}