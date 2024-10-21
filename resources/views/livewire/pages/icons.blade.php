<div class="space-y-6">
    <flux:heading size="xl" level="1">Icons</flux:heading>

    <div class="flex gap-6 sticky">
        <flux:card class="shrink-0 w-60 space-y-4">
            <flux:select variant="listbox" searchable label="Vendor" wire:model.live="vendor">
                @foreach($vendors as $key => $option)
                    <flux:option wire:key="{{ $key }}" value="{{ $key }}">{{ $option }}</flux:option>
                @endforeach
            </flux:select>

            <flux:radio.group wire:model.live="variant" label="Icon variant">
                @foreach($variants as $key => $option)
                    <flux:radio wire:key="{{ $key }}" value="{{ $key }}" label="{{ $option }}" />
                @endforeach
            </flux:radio.group>

        </flux:card>

        <div class="flex flex-1 flex-col space-y-6">
            <flux:input type="search" icon="magnifying-glass" placeholder="Search icons...">
                <x-slot name="iconTrailing" class="flex gap-2">
                    <flux:badge variant="pill" size="sm">{{ $this->iconCount }} icons</flux:badge>
                    <flux:button size="sm" variant="subtle" iconVariant="outline" icon="tabler.filter" class="-mr-1" />
                </x-slot>
            </flux:input>

            <div class="relative">


                <div class="grid grid-cols-6 gap-4">

                    @foreach($this->icons as $icon)
                        <flux:card wire:key="{{ $icon }}" class="relative flex flex-col items-center justify-center space-y-3 !p-2 aspect-square hover:bg-zinc-50 dark:hover:bg-white/5 cursor-pointer transition">
                            <flux:icon icon="{{ $this->getNamespace() }}.{{ $icon }}" variant="{{ $variant }}" class="text-2xl dark:!text-white/90" />
                            <div class="flex flex-col w-full justify-center items-center truncate">
                                <div class="text-xs text-zinc-800/30 dark:!text-white/30">{{ $this->getNamespace() }}.</div>
                                <div class="text-xs text-zinc-800/80 dark:!text-white/50 w-full text-center truncate">{{ $icon }}</div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>

                <div wire:loading  wire:target="vendor" class="absolute h-full w-full backdrop-blur top-0 transition">
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
</div>