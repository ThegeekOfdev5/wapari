<div>
    <div class="border-b border-slate-200">
        <nav aria-label="Breadcrumb" class="px-4 mx-auto overflow-hidden max-w-7xl whitespace-nowrap sm:px-6 lg:px-8">
            <ol role="list" class="flex items-center py-4 space-x-4">
                <li>
                    <div class="flex items-center">
                        <a href="/" class="mr-4 text-sm font-medium text-slate-900">
                            {{ __('Home') }}
                        </a>
                        <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                            class="w-auto h-5 text-slate-300">
                            <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <a href="{{ route('guest.products.list') }}" class="mr-4 text-sm font-medium text-slate-900">
                            {{ __('All products') }}
                        </a>
                        <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                            class="w-auto h-5 text-slate-300">
                            <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                        </svg>
                    </div>
                </li>
                <li class="text-sm truncate">
                    <p href="{{ route('guest.products.detail', $product) }}" aria-current="page"
                        class="font-medium text-slate-500 hover:text-slate-600">
                        {{ $product->name }}
                    </p>
                </li>
            </ol>
        </nav>
    </div>

    <main class="max-w-2xl py-4 mx-auto sm:py-4 sm:px-6 lg:max-w-7xl lg:px-4">
        <div class="relative lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
            @if($product->hasMedia('gallery'))
            <!-- Image gallery -->
            <div wire:ignore x-data="{ current: 0, showNavigator: false }" x-init="$watch('current', value => {
                        $refs.previews.scrollTo({ left: $refs.previews.offsetWidth * value, behavior: 'smooth' });
                        $refs.thumbnails.children[value].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    })" class="flex flex-col-reverse lg:sticky top-10">
                <!-- Image selector -->
                <div class="mx-auto mt-[1.4rem] hidden w-full sm:block">
                    <div x-ref="thumbnails"
                        class="flex sm:gap-[1.8rem] lg:gap-4 xl:gap-[1.4rem] overflow-x-auto scroll-no-bar snap-mandatory snap-x">
                        @foreach($product->getMedia('gallery') as $medium)
                        <button x-on:click="current = {{ $loop->index }}"
                            class="relative flex items-center justify-center flex-shrink-0 w-20 h-20 rounded-md snap-center"
                            :class="{ 'border-2 border-sky-500': current === {{ $loop->index }}, 'border border-slate-200': current !== {{ $loop->index }} }">
                            <img src="{{ $medium->getUrl('thumb') }}" alt="{{ $product->name }}"
                                class="w-16 h-16 rounded-md">
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Image preview -->
                <div x-on:mouseenter="showNavigator = true" x-on:mouseleave="showNavigator = false"
                    class="relative group">
                    <div x-ref="previews"
                        class="flex flex-1 overflow-x-auto scroll-smooth scroll-no-bar snap-mandatory snap-x sm:border sm:border-slate-200 sm:rounded-lg">
                        @foreach($product->getMedia('gallery') as $medium)
                        <div class="flex-shrink-0 w-full h-full snap-center">
                            {{ $medium->hasGeneratedConversion('responsive') ? $medium('responsive')->lazy() :
                            $medium()->lazy() }}
                        </div>
                        @endforeach
                    </div>

                    @if($product->media_count > 1)
                    <button x-cloak x-show="showNavigator"
                        x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="opacity-0 -translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-full"
                        x-on:click="current = current === 0 ? {{ $product->getMedia('gallery')->count() - 1 }} : current - 1"
                        class="absolute items-center p-2 text-white border border-transparent rounded-full shadow-sm top-1/2 left-10 bg-slate-400 hover:enabled:bg-slate-500 focus:outline-none disabled:opacity-25">
                        <span class="sr-only">{{ __('Previous') }}</span>
                        <x-heroicon-m-chevron-left class="w-5 h-5" />
                    </button>
                    <button x-cloak x-show="showNavigator"
                        x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 translate-x-full"
                        x-on:click="current = current === {{ $product->getMedia('gallery')->count() - 1 }} ? 0 : current + 1"
                        class="absolute inline-flex items-center p-2 text-white border border-transparent rounded-full shadow-sm top-1/2 right-10 bg-slate-400 hover:bg-slate-500 focus:outline-none">
                        <span class="sr-only">{{ __('Next') }}</span>
                        <x-heroicon-m-chevron-right class="w-5 h-5" />
                    </button>
                    @endif
                </div>
            </div>
            @else
            <img src="{{ $product->getFirstMediaUrl('gallery') }}" alt="{{ $product->name }}"
                class="object-cover object-center w-full h-full sm:rounded-lg">
            @endif

            <!-- Product info -->
            <div class="px-4 mt-10 sm:mt-16 sm:px-0 lg:mt-0">
                <!-- Title -->
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    {{ $product->name }}
                </h1>

                <!-- Price -->
                <div class="mt-3">
                    <h2 class="sr-only">
                        {{ __('Product information') }}
                    </h2>
                    <p class="text-3xl tracking-tight text-slate-900">
                        <x-money :amount="$variant->price" :currency="config('app.currency')" />
                        @if($variant->compare_price > 0)
                        <span class="text-xl line-through text-slate-500">
                            <x-money :amount="$variant->compare_price" :currency="config('app.currency')" />
                        </span>
                        @endif
                    </p>
                </div>

                <!-- Reviews -->
                <div x-data class="mt-3">
                    <h3 class="sr-only">
                        {{ __('Reviews') }}
                    </h3>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <x-star-rating :rating="$product->reviews->avg('rating')" />
                        </div>
                        <p class="sr-only">
                            {{ __(':rating out of 5 stars', ['rating' =>
                            number_format($product->reviews->avg('rating'))]) }}
                        </p>
                        <button x-on:click="$dispatch('show-product-reviews')" type="button"
                            class="ml-3 text-sm font-medium text-sky-600 hover:text-sky-500">
                            {{ trans_choice(':count review|:count reviews', $product->reviews->count()) }}
                        </button>
                    </div>
                </div>

                <!-- Excerpt -->
                @if($product->excerpt)
                <div class="mt-6">
                    <h3 class="sr-only">
                        {{ __('Description') }}
                    </h3>

                    <div class="space-y-6 text-base text-slate-700">
                        {!! $product->excerpt !!}
                    </div>
                </div>
                @endif

                <!-- Variants -->
                <form wire:submit.prevent="addToCart" class="mt-6">
                    @if($this->productVariants->count())
                    @foreach($this->productOptions as $index => $option)
                    <div @class(['mt-8'=> !$loop->first])>
                        <h3 class="text-sm font-medium text-slate-900">
                            {{ $option->name }}
                        </h3>
                        <fieldset class="mt-2">
                            <legend class="sr-only">
                                {{ __('Choose a') }} {{ $option->name }}
                            </legend>

                            @if($option->visual === 'color' || $option->visual === 'image')
                            <div class="flex items-center space-x-3">
                                @foreach($option->optionValues as $optionValue)
                                <label @class(['-m-0.5 relative p-0.5 rounded-full flex items-center justify-center
                                    cursor-pointer focus:outline-none', "ring-2"=> in_array($optionValue->id,
                                    $selectedOptionValues)])
                                    @style(["--tw-ring-color:$optionValue->value" => in_array($optionValue->id,
                                    $selectedOptionValues)])
                                    data-tippy-content="{{ $optionValue->label }}"
                                    data-tippy-placement="bottom"
                                    >
                                    <input wire:model="selectedOptionValues.{{ $index }}" type="radio"
                                        value="{{ $optionValue->id }}" class="sr-only peer"
                                        aria-labelledby="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                    <p id="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label"
                                        class="sr-only">
                                        {{ $optionValue->label }}
                                    </p>
                                    @if($option->visual === 'color')
                                    <span class="w-8 h-8 border border-black rounded-full border-opacity-10"
                                        style="background-color: {{ $optionValue->value }}"></span>
                                    @elseif($option->visual === 'image')
                                    <span
                                        class="w-8 h-8 bg-center bg-cover border border-black rounded-full border-opacity-10"
                                        style="background-image: url('{{ $optionValue->getFirstMediaUrl('image') }}')"></span>
                                    @endif
                                    <x-heroicon-m-check
                                        class="absolute inset-0 z-0 hidden w-5 h-5 m-auto text-white duration-150 pointer-events-none peer-checked:block" />
                                </label>
                                @endforeach
                            </div>
                            @else
                            <div class="flex flex-wrap gap-4">
                                @foreach($option->optionValues as $optionValue)
                                <label @class(['relative overflow-hidden flex flex-1 items-center justify-center px-4
                                    py-3 cursor-pointer text-sm font-medium uppercase rounded-md shadow-sm
                                    hover:bg-slate-50 focus:outline-none sm:flex-none', 'ring-1 ring-slate-300'=>
                                    !in_array($optionValue->id, $selectedOptionValues), 'ring-2 ring-sky-500' =>
                                    in_array($optionValue->id, $selectedOptionValues)])>
                                    <input wire:model="selectedOptionValues.{{ $index }}" type="radio"
                                        value="{{ $optionValue->id }}" class="sr-only"
                                        aria-labelledby="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                    <span id="{{ Str::slug($option->name) }}-choice-{{ $loop->index }}-label">
                                        {!! $optionValue->label ?? $optionValue->value !!}
                                    </span>
                                    @if(in_array($optionValue->id, $selectedOptionValues))
                                    <div class="absolute bottom-0 right-0 inline-block w-4 overflow-hidden">
                                        <div class="h-6 origin-bottom-left transform rotate-45 bg-sky-500"></div>
                                        <x-heroicon-m-check
                                            class="h-3.5 w-2.5 absolute -bottom-0.5 right-0 text-white" />
                                    </div>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                            @endif
                        </fieldset>
                    </div>
                    @endforeach
                    @endif

                    <div class="flex items-center mt-8 space-x-3">
                        <div>
                            <x-input-label for="productQuantity" :value="__('Quantity')" class="sr-only" />
                            <x-input wire:model.lazy="addToCart.quantity" type="number" id="productQuantity"
                                class="py-3 text-sm text-center w-28 sm:text-base show-spinners" :min="$minQuantity"
                                :max="$maxQuantity" />
                            <x-input-error for="addToCart.quantity" />
                        </div>
                        <div class="flex w-full">
                            <button wire:loading.delay.attr="disabled" class="w-full btn btn-primary btn-xl"
                                @disabled($variant->stock_value < 1)>
                                    {{ $variant->stock_value >= 1 ? __('Add to cart') : __('Sold out') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Specifications -->
                @if($product->specifications->isNotEmpty())
                <section aria-labelledby="specifications-heading" class="mt-12">
                    <h2 id="specifications-heading" class="sr-only">
                        {{ __('Product specifications') }}
                    </h2>

                    <div class="border-t divide-y divide-slate-200">
                        @foreach($product->specifications as $specification)
                        <div x-data="{ expanded: false }">
                            <h3>
                                <button x-on:click="expanded = !expanded" type="button"
                                    class="relative flex items-center justify-between w-full py-6 text-left group"
                                    aria-controls="disclosure-{{ $loop->index }}" :aria-expanded="expanded.toString()">
                                    <span class="text-sm font-medium text-slate-900"
                                        :class="{ 'text-sky-600': expanded, 'text-slate-900': !expanded }">
                                        {{ $specification->name }}
                                    </span>
                                    <span class="flex items-center ml-6">
                                        <x-heroicon-o-arrow-small-down
                                            class="w-6 h-6 text-slate-400 group-hover:text-slate-500"
                                            ::class="{ 'rotate-180': expanded }" aria-hidden="true" />
                                    </span>
                                </button>
                            </h3>
                            <div x-cloak x-collapse x-show="expanded" id="disclosure-{{ $loop->index }}">
                                <div class="pb-6 prose-sm prose">
                                    {!! $specification->value !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>

        <div wire:ignore class="px-4 mt-10 sm:px-0 lg:max-w-none">
            <div x-data="tabs" x-id="['tabs']"
                x-on:show-product-reviews.window="select($id('tabs', 2)); $el.scrollIntoView({ behavior: 'smooth'} )">
                <div class="border-b border-slate-200">
                    <ul x-bind="tablist" class="flex -mb-px space-x-8" aria-orientation="horizontal" role="tablist">
                        <li>
                            <button x-bind="tab" id="tab-description"
                                class="py-6 text-sm font-medium border-b-2 whitespace-nowrap"
                                :class="isSelected($el.id) ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300'"
                                aria-controls="tab-panel-description" role="tab" type="button">
                                {{ __('Product Description') }}
                            </button>
                        </li>
                        <li>
                            <button x-bind="tab" id="tab-reviews"
                                class="py-6 text-sm font-medium border-b-2 whitespace-nowrap"
                                :class="isSelected($el.id) ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300'"
                                aria-controls="tab-panel-reviews" role="tab" type="button">
                                {{ __('Customer Reviews') }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div>
                    <div x-show="isSelected($id('tabs', whichChild($el, $el.parentElement)))" id="tab-panel-description"
                        class="pt-6" role="tabpanel" tabindex="0" aria-labelledby="tab-description">
                        <h3 class="sr-only">{{ __('Product Description') }}</h3>

                        <div class="prose-sm prose prose-slate max-w-none">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div x-cloak x-show="isSelected($id('tabs', whichChild($el, $el.parentElement)))"
                        id="tab-panel-reviews" class="-mb-10" role="tabpanel" tabindex="0"
                        aria-labelledby="tab-reviews">
                        <h3 class="sr-only">{{ __('Customer Reviews') }}</h3>

                        @foreach($product->reviews as $review)
                        <div class="flex space-x-4 text-sm text-slate-500">
                            <div class="flex-none py-10">
                                <img src="{{ $review->customer->getFirstMediaUrl('avatar') }}"
                                    alt="{{ $review->customer->name }}" class="w-10 h-10 rounded-full bg-slate-100">
                            </div>
                            <div class="flex-1 py-10">
                                <h3 class="font-medium text-slate-900">
                                    {{ $review->customer->name }}
                                </h3>
                                <p>
                                    <time datetime="{{ $review->created_at->format('Y-m-d')}}">
                                        {{ $review->created_at->format('F j, Y') }}
                                    </time>
                                </p>
                                <div class="mt-4">
                                    <x-star-rating :rating="$review->rating" />
                                </div>
                                <p class="sr-only">
                                    {{ __(':rating out of 5 stars', ['rating' => $review->rating]) }}
                                </p>
                                <h3 class="mt-4 font-medium text-slate-900">
                                    {{ $review->title }}
                                </h3>
                                <div class="mt-1 prose-sm prose prose-slate max-w-none">
                                    {!! $review->content !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recently viewed products -->
        <div class="px-4 pt-12 sm:pt-24 sm:px-0">
            <div class="flex items-center justify-between space-x-4">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Recently viewed products') }}</h2>
            </div>
            <div class="grid grid-cols-1 mt-6 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                @foreach($this->recentlyViewedProducts as $product)
                <div
                    class="relative flex flex-col p-4 transition rounded-lg group ring-1 ring-slate-200 sm:p-6 hover:ring-1 hover:ring-sky-300 hover:shadow-lg hover:shadow-sky-300/50">
                    <div class="overflow-hidden rounded-lg aspect-h-9 aspect-w-8 group-hover:opacity-75">
                        @if($product->hasMedia('gallery'))
                        {{ $product->getFirstMedia('gallery')->hasGeneratedConversion('responsive') ?
                        $product->getFirstMedia('gallery')('responsive')->attributes(['class' => 'w-full h-full
                        object-cover object-center'])->lazy() : $product->getFirstMedia('gallery')()->lazy() }}
                        @else
                        <img src="{{ $product->getFirstMediaUrl('media') }}" alt="{{ $product->name }}"
                            class="object-cover object-center w-full h-full">
                        @endif
                    </div>
                    <div class="flex flex-col flex-1 pt-10 pb-4 text-center">
                        <h3 class="text-sm font-medium text-slate-900 line-clamp-1">
                            <a href="{{ route('guest.products.detail', $product) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-4 text-base font-medium text-slate-900">
                            <x-money :amount="$product->price" :currency="config('app.currency')"/>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
                Alpine.data('tabs', () => ({
                    selectedId: null, init() {
                        this.$nextTick(() => this.select(this.$id('tabs', 1)))
                    }, select(id) {
                        this.selectedId = id
                    }, isSelected(id) {
                        return this.selectedId === id
                    }, whichChild(el, parent) {
                        return Array.from(parent.children).indexOf(el) + 1
                    }
                }))
                Alpine.bind('tablist', () => ({
                    ['x-ref']: 'tablist', ['@keydown.right.prevent.stop']() {
                        this.$focus.wrap().next()
                    }, ['@keydown.home.prevent.stop']() {
                        this.$focus.first()
                    }, ['@keydown.page-up.prevent.stop']() {
                        this.$focus.first()
                    }, ['@keydown.left.prevent.stop']() {
                        this.$focus.wrap().prev()
                    }, ['@keydown.end.prevent.stop']() {
                        this.$focus.last()
                    }, ['@keydown.page-down.prevent.stop']() {
                        this.$focus.last()
                    },
                }))
                Alpine.bind('tab', () => ({
                    [':id']() {
                        return this.$id('tabs', this.whichChild(this.$el.parentElement, this.$refs.tablist))
                    }, ['@click']() {
                        this.select(this.$el.id)
                    }, ['@focus']() {
                        this.select(this.$el.id)
                    }, [':tabindex']() {
                        return this.isSelected(this.$el.id) ? 0 : -1
                    }, [':aria-selected']() {
                        return this.isSelected(this.$el.id)
                    }, [':class']() {
                        return this.isSelected(this.$el.id) ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-700 hover:text-slate-800 hover:border-slate-300'
                    },
                }))
            })
    </script>
    @endpush
</div>
