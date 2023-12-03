<div
    class="w-1/2 border px-4 py-2"
    wire:ignore {{-- needed in order for the component to not refresh after adding a new tag --}}

    {{-- initializing Taggle using an alpine component --}}
    x-data
    x-init="
        new Taggle($el, {
            tags: {{ $tags }},
            onTagAdd: function(e, tag) {
                Livewire.emit('tagAdded', tag);
            },
            onTagRemove: function(e, tag) {
                Livewire.emit('tagRemoved', tag);
            }
        });

        Livewire.on('addedTag', tag => {
            alert('A tag was added with the name: ' + tag);
        })
    "
>
</div>
