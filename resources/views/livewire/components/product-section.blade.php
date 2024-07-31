<div>
    @if($items)
    <div class="relative mt-1">
        <div class="grid grid-cols-1 gap-6 -mx-px sm:mx-0 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($this->product_items as $product)
            <div
                class="relative p-1 transition rounded-lg group ring-1 ring-slate-200 sm:p-6 hover:ring-1 hover:ring-sky-300 hover:shadow-lg hover:shadow-sky-300/50">
                <div class="overflow-hidden rounded-lg aspect-h-1 aspect-w-1 group-hover:opacity-75">
                    @if($product->hasMedia('gallery'))
                    {{ $product->getFirstMedia('gallery')('responsive')->attributes(['alt' => $product->name, 'class' =>
                    'h-full w-full object-cover object-center']) }}
                    @else
                    <img src="{{ $product->getFirstMediaUrl('gallery') }}" alt="{{ $product->name }}"
                        class="object-cover object-center w-full h-full">
                    @endif
                </div>
                <div class="pt-4 pb-4 text-center">
                    <h3 class="text-sm font-medium text-slate-900 line-clamp-2">
                        <a href="{{ route('guest.products.detail', $product) }}">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="flex flex-col items-center mt-3">
                        <p class="sr-only">
                            {{ trans_choice(':count out of 5 stars', ['count' => $product->reviews->count()]) }}
                        </p>
                        <x-star-rating :rating="$product->reviews->avg('rating')" />
                        <p class="mt-1 text-sm text-slate-500">
                            {{ trans_choice(':count review|:count reviews', $product->reviews->count()) }}
                        </p>
                    </div>
                    <p class="mt-4 text-base font-medium text-slate-900">
                        <x-money :amount="$product->price" :currency="config('app.currency')" />
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @elseif($handle)

    @endif
</div>