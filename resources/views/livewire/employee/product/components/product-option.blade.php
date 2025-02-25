<div>
    <x-card class="relative overflow-hidden">
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                <div class="mt-2 ml-4">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Options') }}
                    </h3>
                </div>
                {{-- @if(!$this->productHasOrder && !$showOptionForm && $product->options_count) --}}
                <div class="flex-shrink-0 mt-2 ml-4">
                    <button wire:click.prevent="showOptionForm" type="button" class="btn btn-link">
                        {{ __('Add new option') }}
                    </button>
                </div>
                {{-- @endif --}}
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <div x-data="{ hasOptionCheckboxChecked: false }" x-init="$watch('hasOptionCheckboxChecked', value => {
                    if (value) {
                        $wire.call('showOptionForm');
                    } else {
                        $wire.call('hideOptionForm');
                    }
                })" class="space-y-6">
                @forelse($product->options as $productOption)
                <div class="relative w-full p-4 mt-3 border rounded-md border-slate-300 dark:border-slate-200/20">
                    <div class="absolute -top-3 left-3 px-0.5 bg-white flex items-center space-x-1 dark:bg-slate-850">
                        {{-- @unless($this->productHasOrder) --}}
                        <button wire:click.prevent="showOptionForm({{ $productOption->id }})" class="btn btn-link">
                            <x-heroicon-s-pencil-square data-tippy-content="{{ __('Edit') }}" class="w-4 h-4" />
                        </button>
                        {{-- @endunless --}}

                        <span class="flex items-center text-sm font-medium text-slate-700 dark:text-slate-200">{{
                            $productOption->name }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        @forelse($productOption->optionValues as $productOptionValue)
                        <div class="relative inline-flex items-center justify-center w-10 h-10 px-2 border rounded-md border-slate-300 min-w-fit group dark:border-slate-200/20"
                            style="@if($productOption->visual === 'color') background-color: {{ Str::lower($productOptionValue->value) }} @endif @if($productOption->visual === 'image') background-image: url({{ $productOptionValue->getFirstMediaUrl('image') }}); background-size: cover; @endif"
                            @isset($productOptionValue->label) data-tippy-content="{{ $productOptionValue->label }}"
                            @endisset
                            >
                            <span @class(['text-sm font-sans font-medium text-slate-400', 'sr-only'=>
                                $productOption->visual !== 'text'])>
                                {{ $productOptionValue->label ?? $productOptionValue->value }}
                            </span>
                        </div>
                        @empty
                        <p class="text-sm text-slate-600">{{ __('This option is ready to be used but has no value yet!')
                            }}</p>
                        @endforelse
                    </div>
                </div>
                @empty
                <div class="relative flex items-center">
                    <x-input x-model="hasOptionCheckboxChecked" type="checkbox" id="hasOptionCheckbox"
                        class="!rounded !shadow-none" />
                    <x-input-label for="hasOptionCheckbox"
                        value="{{ __('This product has option like size or color') }}" class="ml-2" />
                </div>
                @endforelse

                <form x-data="{ showOptionForm: @entangle('showOptionForm')}" x-show="showOptionForm"
                    x-trap.noreturn="showOptionForm" wire:submit.prevent="save">
                    <div
                        class="p-4 mt-6 border border-2 border-dotted rounded-md border-slate-400 dark:border-slate-200/30">
                        <fieldset class="flex space-x-2">
                            <div class="flex-1">
                                <x-input-label for="optionName" value="Option name" />
                                <x-input wire:model.defer="option.name" type="text" id="optionName"
                                    class="block w-full mt-1 sm:text-sm" />
                                <x-input-error for="option.name" class="mt-2" />
                            </div>
                            <div class="flex-shrink-0">
                                <x-input-label for="optionVisual" value="Display as" />
                                <x-select wire:model="option.visual" id="optionVisual"
                                    class="block w-full mt-1 sm:text-sm">
                                    <option value="text">Text</option>
                                    <option value="color">Color</option>
                                    <option value="image">Image</option>
                                </x-select>
                                <x-input-error for="option.visual" class="mt-2" />
                            </div>
                        </fieldset>
                        <div class="relative my-3">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-slate-200 dark:border-slate-200/20"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span
                                    class="px-2 text-sm bg-white text-slate-500 dark:bg-slate-850 dark:text-slate-400">{{
                                    __('Option values') }}</span>
                            </div>
                        </div>
                        <fieldset class="space-y-2">
                            @foreach($optionValues as $index => $optionValue)
                            <div class="flex space-x-2">
                                <div class="flex-1">
                                    <x-input-label for="optionValue-{{ $index }}" value="Option value"
                                        class="sr-only" />
                                    <div class="relative flex items-center mt-1">
                                        <x-input wire:model.defer="optionValues.{{ $index }}.value" type="text"
                                            id="optionValues-{{ $index }}" @class(['w-full sm:text-sm', 'pr-14'=>
                                            $option->visual != 'text'])
                                            :readonly="$option->visual != 'text'"
                                            placeholder="Value"
                                            />
                                            @if($option->visual === 'color')
                                            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                                <label>
                                                    <input
                                                        x-on:change="$wire.set('optionValues.{{ $index }}.value', $event.target.value, true); document.getElementById('optionValues-{{ $index }}').value = $event.target.value"
                                                        type="color" class="border-0 appearance-none"
                                                        value="{{ $optionValue['value'] }}">
                                                </label>
                                            </div>
                                            @endif

                                            @if($option->visual === 'image')
                                            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                                <label
                                                    class="inline-flex items-center px-2 border rounded cursor-pointer border-slate-200 text-slate-500 hover:text-sky-600 dark:border-slate-700 dark:hover:text-sky-400">
                                                    <input wire:model.defer="images.{{ $index }}" type="file"
                                                        class="sr-only">
                                                    <x-heroicon-o-arrow-up-tray class="w-5 h-5" />
                                                </label>
                                            </div>
                                            @endif
                                    </div>
                                    <x-input-error for="optionValues.{{ $index }}.value" class="mt-2" />
                                </div>
                                <div class="flex-1">
                                    <x-input-label for="optionLabel-{{ $index }}" value="Option label"
                                        class="sr-only" />
                                    <x-input wire:model.defer="optionValues.{{ $index }}.label" type="text"
                                        id="optionLabel-{{ $index }}" class="block w-full mt-1 sm:text-sm"
                                        placeholder="Label" />
                                    <x-input-error for="optionValues.{{ $index }}.label" class="mt-2" />
                                </div>
                                @if(count($optionValues) > 0)
                                <div class="flex items-center flex-shrink-0">
                                    <div class="flex"
                                        data-tippy-content="{{ array_key_exists('id', $optionValue) ? __('You can\'t delete this value because it\'s already in use') : __('Delete') }}">
                                        <button wire:click.prevent="deleteOptionValueInputs({{  $index }})"
                                            type="button"
                                            class="p-0 text-red-500 btn hover:text-red-600 dark:hover:text-red-400"
                                            @disabled(array_key_exists('id', $optionValue))>
                                            <x-heroicon-m-trash class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </fieldset>
                        <div class="flex justify-between mt-6">
                            <button wire:click.prevent="addOptionValueInputs" type="button" class="btn btn-link">
                                {{ __('Add option value') }}
                            </button>
                            <div class="space-x-2">
                                <button wire:click.prevent="hideOptionForm" type="button" class="btn btn-link">
                                    {{ __('Cancel') }}
                                </button>
                                <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                    {{ __('Save option') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot:content>
    </x-card>
</div>