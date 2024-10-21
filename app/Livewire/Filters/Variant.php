<?php

namespace App\Livewire\Filters;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Ympact\FluxIcons\Services\IconBuilder;

class Variant extends Component
{
    #[Modelable]
    public $variant;

    public $variants;

    public function mount()
    {
        $this->variants = [
            'outline' => 'Outline',
            'solid' => 'Solid',
            'mini' => 'Mini',
            'micro' => 'Micro',
        ];
    }
}