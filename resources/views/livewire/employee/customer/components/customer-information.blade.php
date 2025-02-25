<div>
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                <div class="mt-2 ml-4">
                    <h2 class="text-lg font-medium leading-6 text-slate-900 dark:text-slate-100">
                        {{ __('Customer') }}
                    </h2>
                </div>
                <div class="flex-shrink-0 mt-2 ml-4">
                    <button wire:click.prevent="edit" type="button" class="btn btn-link">
                        {{ __('Edit') }}
                    </button>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            <ul x-data class="space-y-2 sm:text-sm">
                <li class="flex items-between">
                    <a href="mailto:{{ $customer->email }}" class="btn btn-link block w-full !justify-start">
                        {{ $customer->email }}
                    </a>
                    <button
                        x-on:click="$clipboard('{{ $customer->email }}').then(() => $dispatch('notify', '{{ __('Copied to clipboard') }}'))"
                        type="button" data-tippy-content="{{ __('Copy to clipboard') }}">
                        <x-heroicon-m-clipboard
                            class="w-5 h-5 text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                    </button>
                </li>
                @if($customer->phone)
                <li>{{ $customer->phone}}</li>
                @endif
            </ul>
        </x-slot:content>
    </x-card>

    <form wire:submit.prevent="save">
        <x-modal-dialog wire:model.defer="isEditing" max-width="xl">
            <x-slot:title>
                {{ __('Edit customer') }}
            </x-slot:title>
            <x-slot:content>
                <fieldset wire:target="save" wire:loading.attr="disabled" class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input wire:model.defer="customer.name" id="name" type="text"
                            class="block w-full mt-1 sm:text-sm" required />
                        <x-input-error for="customer.name" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-input wire:model.defer="customer.email" id="email" type="email"
                            class="block w-full mt-1 sm:text-sm" required />
                        <x-input-error for="customer.email" class="mt-2" />
                    </div>
                    <div x-data="{ open: false }">
                        <x-input-label for="phone-number" value="{{ __('Phone number') }}" />
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center">
                                <div class="relative h-full">
                                    <button x-on:click="open = true" type="button"
                                        class="relative w-full h-full pl-3 pr-8 text-left border border-transparent rounded-md cursor-default focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm">
                                        <span class="text-2xl">{{ $country->emoji }}</span>
                                        <span
                                            class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                            <x-heroicon-m-chevron-up-down class="w-5 h-5 text-slate-400" />
                                        </span>
                                    </button>
                                    <ul x-show="open" x-on:click.away="open = false"
                                        class="absolute bottom-full z-10 mb-1.5 max-h-56 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm dark:bg-slate-900">
                                        @foreach($countries as $country)
                                        <li x-on:click="$wire.selectCountry('{{ $country->iso2 }}'); open = false;"
                                            class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9 hover:bg-sky-500 hover:text-white dark:text-slate-200">
                                            <div class="flex items-center">
                                                <span class="text-2xl">{{ $country->emoji }}</span>
                                                <span class="block ml-3 font-normal truncate">{{ $country->name
                                                    }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-input wire:model.defer="phone" type="text" id="phone-number"
                                class="block w-full pl-[4.5rem] sm:text-sm" />
                        </div>
                        <x-input-error for="phone" class="mt-2" />
                    </div>
                </fieldset>
            </x-slot:content>
            <x-slot:footer>
                <div class="flex justify-end">
                    <button wire:click="$set('isEditing', false)" wire:target="save" wire:loading.attr="disabled"
                        type="button" class="btn btn-invisible">
                        {{ __('Cancel') }}
                    </button>
                    <button wire:target="save" wire:loading.attr="disabled" type="submit" class="ml-2 btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </x-slot:footer>
        </x-modal-dialog>
    </form>
</div>