<div
    x-data="{ searchOpen: false }"
    x-on:keydown.slash.window="if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA' && !document.activeElement.isContentEditable) searchOpen = true"
>
    <div
        x-cloak
        x-show="searchOpen"
        x-trap.noreturn="searchOpen"
        x-on:open-search.window="searchOpen = true"
        x-on:keydown.escape="searchOpen = false"
        class="relative z-[60]"
        role="dialog"
        aria-modal="true"
    >
        <div
            x-show="searchOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur"
        ></div>

        <div class="fixed inset-0 z-10 p-4 overflow-y-auto sm:p-6 md:p-20">
            <div
                x-show="searchOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-on:click.away="searchOpen = false"
                class="max-w-xl mx-auto overflow-hidden transition-all transform bg-white divide-y shadow-2xl divide-slate-100 rounded-xl ring-1 ring-black ring-opacity-5 dark:bg-slate-800 dark:divide-white/10 dark:ring-1 dark:ring-slate-700"
            >
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-slate-400" />
                    <label
                        for="search"
                        class="sr-only"
                    >
                        {{ __('Search') }}
                    </label>
                    <input
                        wire:model.debounce.500ms="query"
                        type="search"
                        id="search"
                        class="w-full h-12 pr-4 bg-transparent border-0 pl-11 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-sm dark:text-white"
                        placeholder="{{ __('Type to search...') }}"
                        autocomplete="off"
                    >
                </div>

                <div
                    wire:loading.delay
                    wire:target="query"
                    class="w-full px-6 py-3"
                >
                    <div wire:loading.class="w-full">
                        <div class="flex space-x-4 animate-pulse">
                            <div class="w-10 h-10 rounded-lg bg-slate-200"></div>
                            <div class="flex-1 py-1 space-y-4">
                                <div class="h-2 rounded bg-slate-200"></div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="h-2 col-span-2 rounded bg-slate-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($query)
                    <ul
                        wire:loading.delay.remove
                        wire:target="search"
                        class="p-3 overflow-y-auto max-h-96 scroll-py-3"
                        id="options"
                        role="listbox"
                    >
                        @forelse($this->products as $product)
                            <li
                                wire:key="product-{{ $product->id }}"
                                class="relative flex items-center p-3 cursor-default select-none group rounded-xl hover:bg-slate-100 dark:hover:bg-white/5"
                            >
                                <div class="flex items-center justify-center flex-none w-10 h-10 rounded-lg bg-slate-200 dark:bg-slate-800">
                                    <img
                                        src="{{ $product->getFirstMediaUrl('gallery', 'thumb_large') }}"
                                        alt="{{ $product->name }}"
                                        class="rounded-md"
                                    >
                                </div>
                                <div class="flex-auto ml-4">
                                    <a
                                        href="{{ $searchFromAdmin ? route('employee.products.detail', $product->id) : route('guest.products.detail', $product->slug) }}"
                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900 dark:text-slate-200 dark:group-hover:text-white"
                                    >
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                    <p class="text-sm text-slate-500 group-hover:text-slate-700 dark:text-slate-400 dark:group-hover:text-slate-200">
                                        <x-money :amount="$product->price" :currency="config('app.currency')"/>
                                    </p>
                                </div>
                            </li>
                        @empty
                            <div class="px-6 text-sm text-center py-14 sm:px-14">
                                <x-heroicon-o-information-circle class="w-6 h-6 mx-auto text-slate-400" />
                                <p class="mt-4 font-semibold text-slate-900 dark:text-slate-200">
                                    {{ __('No results found') }}
                                </p>
                                <p class="mt-2 text-slate-500 dark:text-slate-400">
                                    {{ __('Try adjusting your search or filter to find what you\'re looking for.') }}
                                </p>
                            </div>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
