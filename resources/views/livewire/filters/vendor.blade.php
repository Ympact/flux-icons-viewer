<flux:select label="Vendor" wire:model="vendor">
    @foreach($vendors as $key => $vendor)
        <flux:select.option wire:key="$key" value="{{ $key }}">{{ $vendor }}</flux:select.option>
</flux:select>
