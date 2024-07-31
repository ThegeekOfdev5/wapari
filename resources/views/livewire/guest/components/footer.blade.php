<footer class="bottom-0 bg-slate-900" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">
        {{ __('Footer') }}
    </h2>
    <div @class(['mx-auto max-w-7xl px-6', 'pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-6'=>
        $this->layoutSettings->footer_bottom_bar_enabled, 'mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8 lg:py-32' =>
        !$this->layoutSettings->footer_bottom_bar_enabled])>
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="mr-5 space-y-8">
                <a href="/">
                    <span class="sr-only">{{ config('app.name') }}</span>
                    <img src="{{ $brandSettings->logo_path ? Storage::url($brandSettings->logo_path) : asset('img/logo.png') }}"
                        alt="{{ config('app.name') }}" class="w-auto h-32" height="32" width="32" />
                </a>
                <p class="text-sm leading-6 text-justify text-slate-300">
                    {{ $brandSettings->slogan }}
                </p>
            </div>
            <div class="grid justify-end grid-cols-2 gap-8 mt-16 sm:grid-cols-4 xl:col-span-2 xl:mt-0">
                @if($this->footerMenu)
                @foreach($this->footerMenu->menuItems as $menuItem)
                <div @class([''=> !$loop->first])>
                    <h3 class="text-sm font-semibold leading-6 text-white">
                        {{ $menuItem->name }}
                    </h3>
                    @if($menuItem->children->count())
                    <ul role="list" class="mt-6 space-y-4">
                        @foreach($menuItem->children as $child)
                        <li>
                            <a href="{{ $child->url }}" class="text-sm leading-6 text-slate-300 hover:text-white">
                                {{ $child->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="pt-8 mt-16 border-t border-white/10 sm:mt-20 md:flex md:items-center md:justify-between lg:mt-10">
            <div class="flex space-x-6 md:order-2">
                @foreach($brandSettings->social_links as $socialLink)
                @if($socialLink['url'])
                <a href="{{ $socialLink['url'] }}" class="text-slate-500 hover:text-slate-400">
                    <span class="sr-only">{{ $socialLink['name'] }}</span>
                    <x-icon name="simpleicon-{{ Str::lower($socialLink['name']) }}" class="w-6 h-6" />
                </a>
                @endif
                @endforeach
            </div>
            <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">
                {!! $layoutSettings->footer_bottom_bar_message !!}
            </p>
        </div>
    </div>
</footer>
