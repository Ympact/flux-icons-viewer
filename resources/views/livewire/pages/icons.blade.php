<div class="space-y-6">
    <flux:heading size="xl" level="1">Icons</flux:heading>

    <div class="flex gap-6 sticky">
    <flux:card class="shrink-0 w-60 space-y-4">

        <flux:select label="Vendor">
            <flux:option value="tabler" label="Tabler" />
            <flux:option value="heroicons" label="Heroicons" />
            <flux:option value="feather" label="Feather" />
            <flux:option value="eva" label="Eva" />
            <flux:option value="line" label="Line" />
            <flux:option value="remix" label="Remix" />
            <flux:option value="simple" label="Simple" />
            <flux:option value="zondicons" label="Zondicons" />
        </flux:select>

        <flux:radio.group wire:model="variant" label="Icon variant">
            <flux:radio value="outline" label="Outline" checked />
            <flux:radio value="solid" label="Solid" />
            <flux:radio value="mini" label="Mini" />
            <flux:radio value="micro" label="Micro" />
        </flux:radio.group>
    </flux:card>

    <div class="flex flex-1 flex-col space-y-6">
        <flux:input type="search" icon="magnifying-glass" placeholder="Search icons...">
            <x-slot name="iconTrailing">
                <flux:button size="sm" variant="subtle" iconVariant="outline" icon="tabler.filter" class="-mr-1" />
            </x-slot>
        </flux:input>
        
        <div class="flex  gap-4">

            <flux:card class="relative flex flex-col items-center justify-center space-y-3 aspect-square hover:bg-zinc-50 dark:hover:bg-white/5 cursor-pointer transition">
                <flux:icon.tabler.home class="text-2xl dark:!text-white/90" />
                <span class="text-xs dark:!text-white/70"">tabler.home</span>
            </flux:card>

        </div>

    </div>

    </div>
</div>