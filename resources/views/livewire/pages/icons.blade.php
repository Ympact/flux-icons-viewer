<div class="space-y-6" x-data="{ viewSize: 24, currentIcon: null }">
    <flux:heading size="xl" level="1">Flux Icons <span wire:target="vendor" wire:loading.class="hidden transition">{{ $this->getVendorName() }}</span><flux:icon.loading  wire:target="vendor" wire:loading /></flux:heading>

    <div class="flex gap-6 sticky">
        <flux:card class="shrink-0 w-60 space-y-6">
            <flux:select variant="listbox" searchable label="Vendor" wire:model.live="vendor">
                @foreach($vendors as $key => $option)
                    <flux:select.option wire:key="{{ $key }}" value="{{ $key }}">{{ $option }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:radio.group wire:model.live="variant" label="Icon variant">
                @foreach($variants as $key => $option)
                    <flux:radio wire:key="{{ $key }}" value="{{ $key }}" label="{{ $option }}" />
                @endforeach
            </flux:radio.group>
                
            <!-- input slider to increase view size of the icons -->
            <flux:field class="flex flex-col">
                <flux:label>View size</flux:label>
                <div>
                    <input type="range" min="1" max="50" step="1"  class="w-1/2" x-model="viewSize">
                    <flux:badge variant="subtle" size="sm">x</flux:badge>
                    <flux:button icon="tabler.refresh" @click="viewSize=24" variant="subtle" iconVariant="outline" size="sm" />
                </div>
            </flux:field>
        </flux:card>

        <div class="flex flex-1 flex-col space-y-6">
            <flux:input type="search" icon="magnifying-glass" wire:model.live="query" placeholder="Search icons..." >
                <x-slot name="iconTrailing" class="flex gap-2">
                    <flux:badge variant="pill" size="sm">{{ $this->iconCount }} icons</flux:badge>
                    <flux:button size="sm" variant="subtle" iconVariant="outline" icon="tabler.filter" class="-mr-1" />
                </x-slot>
            </flux:input>

            <div class="relative">


                <div class="grid grid-cols-6 gap-4" x-ref="gallery">

                    @foreach($this->icons as $icon)
                        <flux:card as="button" wire:key="{{ $icon['icon'] }}" 
                            x-on:click="$wire.showIconModal('{{ $icon['icon'] }}')"
                            class="relative flex flex-col items-center justify-center space-y-3 p-2! aspect-square hover:bg-zinc-50 dark:hover:bg-white/5 cursor-pointer transition">
                            <flux:icon x-bind:style="{'width': viewSize+'px', 'height':viewSize+'px'}" icon="{{ $this->getNamespace() }}.{{ $icon['icon'] }}" variant="{{ $variant }}" class="text-2xl dark:text-white/90!" />
                            <div class="flex flex-col w-full justify-center items-center truncate">
                                <div class="text-xs text-zinc-800/30 dark:text-white/30!">{{ $this->getNamespace() }}.</div>
                                <div class="text-xs text-zinc-800/80 dark:text-white/50! w-full text-center truncate">{{ $icon['icon'] }}</div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>

                <div wire:loading  wire:target="vendor" class="absolute h-full w-full backdrop-blur-sm top-0 transition">
                    <flux:card class="h-full w-full inset-4 flex items-center justify-center gap-4"> 
                        <flux:icon.loading />
                        <div>Loading icons</div>
                    </flux:card>           
                </div>   

            </div>

            <!-- Pagination -->
            <div class="flex justify-center space-x-2">
                <flux:button wire:click="previousPage" icon="tabler.chevron-left" variant="subtle" iconVariant="outline" /> {{--   disabled="{{ $this->page <= 1 }}" --}}
                <flux:button wire:click="nextPage" icon="tabler.chevron-right" variant="subtle" iconVariant="outline"  /> {{-- disabled="{{ $this->page >= $this->pageCount }}" --}}
            </div>
        </div>

    </div>

    <flux:modal name="show-icon" class="md:w-96 space-y-6" wire:model.self="iconModal" @close="closeIconModal">

            <flux:heading size="lg">Icon</flux:heading>
            @if($this->selectedIcon )
            <flux:card class="bg-zinc-50 flex items-start">
                <flux:header>Original icon</flux:header>
                <div class="flex items-center justify-center">
                    {!! $this->orginalIcon !!}
                </div>
            </flux:card>
            <flux:header>Flux variants</flux:header>
            <div class="flex items-stretch space-x-4">
                <flux:card class="items-center justify-center">
                    <flux:icon icon="{{ $this->vendor }}.{{ $this->selectedIcon }}" variant="outline" />
                </flux:card>
                <flux:card class="items-center justify-center">
                    <flux:icon icon="{{ $this->vendor }}.{{ $this->selectedIcon }}" variant="solid" />
                </flux:card>
                <flux:card class="items-center justify-center">
                    <flux:icon icon="{{ $this->vendor }}.{{ $this->selectedIcon }}" variant="mini" />
                </flux:card>
                <flux:card class="items-center justify-center">
                    <flux:icon icon="{{ $this->vendor }}.{{ $this->selectedIcon }}" variant="micro" />
                </flux:card>
            </div>

            @endif


            <flux:separator/>
            <div  class="flex items-center space-x-2 justify-center">
            <flux:button icon="arrow-left"></flux:button>
            <flux:button iconTrailing="arrow-right"></flux:button>
            </div>

    </flux:modal>

</div>