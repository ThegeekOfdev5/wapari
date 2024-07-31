<main>
    @if($this->hero_carousel)
        <div
            x-data="{ current: 0 }"
            class="relative overflow-auto"
        >
            <ul
                x-ref="slider"
                autoplayIntervalTime: 4000
                class="flex flex-1 overflow-x-auto overflow-y-hidden scroll-smooth scroll-no-bar snap-mandatory snap-x"
            >
                @foreach($this->hero_carousel->slides as $slide)
                    <li
                        x-intersect.threshold.90="$nextTick(() => current = {{ $loop->index }})"
                        class="w-full snap-center shrink-0"
                    >
                        <div class="relative h-full bg-slate-900">
                            <div
                                aria-hidden="true"
                                class="absolute inset-0"
                            >
                                @if($slide->hasMedia('image'))
                                    {{ $slide->getFirstMedia('image')('responsive')->attributes(['class' => 'h-full w-full object-cover object-center']) }}
                                @else
                                    <img
                                        src="{{ asset('img/placeholder-wide.png') }}"
                                        alt="{{ $slide->title }}"
                                        class="object-cover object-center w-full h-full"
                                    >
                                @endif
                            </div>
                            <div class="relative h-full px-6 py-32 bg-opacity-50 bg-slate-900 sm:px-12 sm:py-40 lg:px-16">
                                <div class="relative flex flex-col items-center max-w-3xl mx-auto text-center">
                                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                        {{ $slide->title }}
                                    </h2>
                                    @if($slide->description)
                                        <p class="mt-3 text-xl text-white line-clamp-2">
                                            {{ $slide->description }}
                                        </p>
                                    @endif
                                    @if($slide->button_link && $slide->button_text)
                                        <a
                                            href="{{ $slide->button_link }}"
                                            class="block w-full px-8 py-3 mt-8 text-base font-medium bg-white border border-transparent rounded-md text-slate-900 hover:bg-slate-100 sm:w-auto"
                                        >
                                            {{ $slide->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="absolute inset-x-0 flex justify-center space-x-3 bottom-10">
                @foreach($this->hero_carousel->slides as $slide)
                    <button x-on:click="$refs.slider.scrollTo({ left: $refs.slider.offsetWidth * {{ $loop->index }}, behavior: 'smooth' })">
                        <span class="sr-only">
                            {{ __('Slide :count', ['count' => $loop->index + 1]) }}
                        </span>
                        <span
                            class="block w-2 h-2 rounded-full ring-2 ring-white ring-opacity-50 hover:ring-opacity-100"
                            :class="{ 'bg-white ring-opacity-100': current === {{ $loop->index }} }"
                        ></span>
                    </button>
                @endforeach
            </div>
        </div>
    @else
        <div class="relative bg-slate-900">
            <div
                aria-hidden="true"
                class="absolute inset-0"
            >
                <img
                    src="{{ asset('img/placeholder-wide.png') }}"
                    alt="{{ __('Hero carousel placeholder') }}"
                    class="object-cover object-center w-full h-full"
                >
            </div>
            <div class="relative px-6 py-32 bg-opacity-50 bg-slate-900 sm:px-12 sm:py-40 lg:px-16">
                <div class="relative flex flex-col items-center max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        {{ __('Hero carousel title') }}
                    </h2>
                    <p class="mt-3 text-xl text-white line-clamp-2">
                        {{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') }}
                    </p>
                    <a
                        href="javascript:void(0);"
                        class="block w-full px-8 py-3 mt-8 text-base font-medium bg-white border border-transparent rounded-md cursor-not-allowed text-slate-900 hover:bg-slate-100 sm:w-auto"
                    >
                        {{ __('Shop now') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($this->perk_carousel)
        <div class="bg-slate-50">
            <h2 class="sr-only">{{ __('Our perks') }}</h2>
            <div class="mx-auto divide-y max-w-7xl divide-slate-200 lg:flex lg:divide-x lg:divide-y-0 lg:py-8">
                @foreach($this->perk_carousel->slides as $slide)
                    <div class="py-8 lg:w-1/3 lg:flex-none lg:py-0">
                        <div class="flex items-center max-w-xs px-4 mx-auto lg:max-w-none lg:px-8">
                            @if($slide->hasMedia('image'))
                                <img
                                    src="{{ $slide->getFirstMediaUrl('image') }}"
                                    alt="{{ $slide->title }}"
                                    class="flex-shrink-0 w-12 h-12 mr-4"
                                >
                            @endif
                            <div class="flex flex-col-reverse flex-auto">
                                <h3 class="font-medium text-slate-900">{{ $slide->title }}</h3>
                                <p class="text-sm text-slate-500">{{ $slide->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @foreach(collect($this->template_settings->home_page_sections)->sortBy('order') as $section)
        <section @class(['bg-white px-4 pt-24 space-y-5 sm:px-6 sm:pt-14 xl:mx-auto xl:max-w-7xl lg:px-8', 'pb-24 sm:pb-20' => $loop->last])>
            <div class="sm:flex sm:items-center sm:justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    {{ $section['title'] }}
                </h2>
                @if($section['link'] && $section['link_text'])
                    <a
                        href="{{ $section['link'] }}"
                        class="hidden text-sm font-semibold text-sky-700 hover:text-sky-600 sm:block"
                    >
                        {!! $section['link_text'] !!}
                        <span aria-hidden="true"> &rarr;</span>
                    </a>
                @endif
            </div>
            @if($section['banner_path'])
                <img
                    src="{{ Storage::url($section['banner_path']) }}"
                    alt="{{ $section['title'] }}"
                    class="object-center w-full h-48 rounded-lg"
                />
            @endif
            @if($section['type'] === 'collection')
                <livewire:components.collection-section
                    :handle="$section['carousel_handle']"
                    :items="$section['items']"
                />
            @elseif($section['type'] === 'product')
                <livewire:components.product-section
                    :handle="$section['carousel_handle']"
                    :items="$section['items']"
                />
            @elseif($section['type'] === 'blog')
                <livewire:components.blog-section />
            @endif
        </section>
    @endforeach
</main>
