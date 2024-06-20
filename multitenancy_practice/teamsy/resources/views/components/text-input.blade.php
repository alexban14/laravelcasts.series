@props([
    'type' => "text",
    'label' => "",
    'required' => false,
    'placeholder' => ""
])
<div class="{{$attributes->whereStartsWith('wire:model')->first()}}">
    <label for="{{$attributes->whereStartsWith('wire:model')->first()}}" class="block text-sm font-medium leading-5 text-gray-700">
        {{$label}}
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <input
            wire:model="{{$attributes->whereStartsWith('wire:model')->first()}}"
            id="email"
            required="{{$required}}"
            placeholder="{{$placeholder}}"
            @error($attributes->whereStartsWith('wire:model')->first())
                class="form-input block w-full pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300"
                aria-invalid="true"
                aria-describedby="email-error"
            @else
                class="form-input block w-full sm:text-sm sm:leading-5"
            @endif
        />
        @error($attributes->whereStartsWith('wire:model')->first())
            <div>
                <p wire:key="error_{{$attributes->whereStartsWith('wire:model')->first()}}" class="mt-2 text-sm text-red-600" id="email-error">
                    {{$message}}
                </p>
            </div>
        @enderror
    </div>
</div>
