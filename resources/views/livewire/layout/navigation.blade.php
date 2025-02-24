
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
        <flux:tooltip content="Switch to dark mode">
            <flux:navbar.item icon="tabler.moon" iconVariant="outline" iconSize="sm" label="Dark mode" @click="$store.darkMode.toggle()" x-show="!$store.darkMode.on" x-cloak></flux:menu.item>
        </flux:tooltip>
        <flux:tooltip content="Switch to light mode">
            <flux:navbar.item icon="tabler.sun" label="Light mode" @click="$store.darkMode.toggle()" x-show="$store.darkMode.on" x-cloak></flux:menu.item>
        </flux:tooltip>
        <flux:separator vertical />
        <flux:tooltip content="Visit Github repository">
            <flux:navbar.item icon="tabler.brand-github" href="https://github.com/Ympact/flux-icons" target="_new" label="Github"></flux:menu.item>
        </flux:tooltip>
    </flux:navbar>

</flux:header>

<script>
    document.addEventListener('livewire:navigated', () => {
        // wire:navigate will wipe out the dark class on the body element, se we need to reapply it...
        Alpine.store('darkMode').applyToBody()
    })
    
    document.addEventListener('alpine:init', () => {

    Alpine.store('darkMode', {
        on: false,

        toggle() {
            console.log('toggle')
            this.on = ! this.on
        },

        on() {
            this.on = true
        },

        off() {
            this.on = false
        },

        init() {
            console.log('init')
            this.on = this.wantsDarkMode()

            Alpine.effect(() => {
                document.dispatchEvent(new CustomEvent('dark-mode-toggled', { detail: { isDark: this.on }, bubbles: true }))
                this.applyToBody()
            })

            // Putting this in a set timeout to wait for the iframes to be loaded...
            setTimeout(() => {
                Alpine.effect(() => {
                    this.applyToIframes()
                })
            }, 5000)

            let media = window.matchMedia('(prefers-color-scheme: dark)')

            media.addEventListener('change', e => {
                this.on = media.matches
            })
        },

        wantsDarkMode() {
            let media = window.matchMedia('(prefers-color-scheme: dark)')

            if (window.localStorage.getItem('darkMode') === '') {
                return media.matches
            } else {
                return JSON.parse(window.localStorage.getItem('darkMode'))
            }
        },

        applyToBody() {
            let state = this.on

            window.localStorage.setItem('darkMode', JSON.stringify(state))

            state ? document.body.classList.add('dark') : document.body.classList.remove('dark')
        },

        applyToIframes() {
            let state = this.on

            // Update dark mode inside iframes...
            state
                ? document.querySelectorAll('iframe').forEach(iframe => iframe.contentDocument?.querySelector('body')?.classList?.add('dark'))
                : document.querySelectorAll('iframe').forEach(iframe => iframe.contentDocument?.querySelector('body')?.classList?.remove('dark'))
        }
    })
})
</script>