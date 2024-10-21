<flux:select label="Vendor" wire:model="vendor">
    @foreach($vendors as $key => $vendor)
        <flux:option wire:key="$key" value="{{ $key }}">{{ $vendor }}</flux:option>
</flux:select>
