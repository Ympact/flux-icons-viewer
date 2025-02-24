
<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700  transition-colors">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <div class="flex gap-2 items-center">
        <flux:icon.tabler.windmill class="dark:text-white!" /> <flux:heading>Flux Icons</flux:heading>
    </div>

    <flux:spacer />
    {{--  
    <flux:brand href="#" logo="" name="Flux Icons" class="max-lg:hidden dark:hidden" />
    <flux:brand href="#" logo="" name="Flux Icons" class="max-lg:hidden! hidden dark:flex" />
    --}}
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="tabler.home" href="/"  wire:navigate>Home</flux:navbar.item>
        <flux:navbar.item icon="tabler.icons" href="/icons" wire:navigate>Icons</flux:navbar.item>
        <flux:navbar.item icon="tabler.info-square-rounded" href="/docs" wire:navigate>Documentation</flux:navbar.item>
    </flux:navbar>

    <flux:spacer />

    <flux:navbar class="mr-4">
        <flux:dropdown x-data align="end">
            <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" class="text-zinc-500 dark:text-white" />
                <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" class="text-zinc-500 dark:text-white" />
                <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
            </flux:button>
        
            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
{{--
        <flux:tooltip content="Switch to dark mode">
            <flux:navbar.item icon="tabler.moon" iconVariant="outline" iconSize="sm" label="Dark mode" @click="$store.darkMode.toggle()" x-show="!$store.darkMode.on" x-cloak></flux:menu.item>
        </flux:tooltip>
        <flux:tooltip content="Switch to light mode">
            <flux:navbar.item icon="tabler.sun" label="Light mode" @click="$store.darkMode.toggle()" x-show="$store.darkMode.on" x-cloak></flux:menu.item>
        </flux:tooltip>
--}}
        <flux:separator vertical />
        <flux:tooltip content="Visit Github repository">
            <flux:navbar.item icon="tabler.brand-github" href="https://github.com/Ympact/flux-icons" target="_new" label="Github"></flux:menu.item>
        </flux:tooltip>
    </flux:navbar>

</flux:header>
