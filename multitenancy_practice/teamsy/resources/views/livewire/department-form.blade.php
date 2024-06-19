<div>
    <input wire:model="name" type="text" />
    <button wire:click="submit">Submit</button>

    @if($success) <div class="text-white">Saved</div>@endif
</div>
