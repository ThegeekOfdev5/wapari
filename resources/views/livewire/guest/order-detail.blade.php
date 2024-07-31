<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Orders - :orderId', ['orderId' => $order->id]) }}
    </x-slot:title>

    <div class="bg-white">
        <div class="max-w-3xl px-4 py-3 mx-auto sm:px-6 sm:py-8 lg:px-8">
            <div class="max-w-xl">
                <h1 class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">
                    {{ __('Thanks for ordering') }}
                </h1>
                <p class="mt-2 text-base text-slate-500">
                    {{ __('We appreciate your order, we’re currently processing it. So hang tight, and we’ll send you confirmation very soon!') }}
                </p>
                <dl class="grid flex-1 grid-cols-2 gap-6 mt-12 text-sm sm:col-span-4 sm:grid-cols-4 lg:col-span-2">
                    <div>
                        <dt class="font-medium text-gray-900">{{ __('Order number') }}</dt>
                        <dd class="mt-1 font-medium text-sky-600">{{ $order->id }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">{{ __('Order date') }}</dt>
                        <dd class="mt-1 font-medium text-sky-600">{{ $order->created_at->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">{{ __('Payment status') }}</dt>
                        <dd class="mt-1 font-medium text-sky-600">{{ $order->payment_status->label() }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-900">{{ __('Shipping status') }}</dt>
                        <dd class="mt-1 font-medium text-sky-600">{{ $order->shipping_status->label() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-10 border-t border-slate-200">
                <h2 class="sr-only">{{ __('Your order') }}</h2>

                <h3 class="sr-only">{{ __('Items') }}</h3>

                <ul
                    role="list"
                    class="border-b divide-y divide-slate-200 border-slate-200"
                >
                    @foreach($order->orderItems as $item)
                        <li class="py-4 sm:py-6">
                            <div class="flex items-center sm:items-stretch">
                                <div class="relative flex-shrink-0 w-20 h-20 overflow-hidden border rounded-md border-slate-200 sm:h-40 sm:w-40">
                                    @if($item->variant->hasMedia('image'))
                                        {{ $item->variant->getFirstMedia('image')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-full w-full object-cover object-center']) }}
                                    @elseif($item->product->hasMedia('gallery'))
                                        {{ $item->product->getFirstMedia('gallery')('thumb_large')->attributes(['alt' => $item->product->name, 'class' => 'h-full w-full object-cover object-center']) }}
                                    @else
                                        <x-heroicon-o-camera class="absolute inset-0 w-16 h-full mx-auto text-slate-400 sm:w-24" />
                                    @endif
                                </div>
                                <div class="flex flex-col justify-between flex-1 ml-6 text-sm">
                                    <div>
                                        <div class="font-medium text-slate-900 sm:flex sm:justify-between">
                                            <h4>
                                                {{ $item->quantity }}x
                                                {{ $item->product->name }}
                                            </h4>
                                            <p class="mt-2 sm:mt-0">
                                                <x-money
                                                    :amount="$item->price"
                                                    :currency="config('app.currency')"
                                                />
                                            </p>
                                        </div>
                                        @if($item->variant->variantAttributes->count())
                                            <ul class="mt-2 space-x-2 divide-x divide-slate-200 text-slate-700">
                                                @foreach($item->variant->variantAttributes as $attribute)
                                                    <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="hidden mt-2 sm:flex">
                                        <div class="flex items-center space-x-4 text-sm font-medium divide-x divide-slate-200">
                                            <div class="flex justify-center flex-1">
                                                <a
                                                    href="{{ route('guest.products.detail', $item->product) }}"
                                                    class="btn btn-link whitespace-nowrap"
                                                >
                                                    {{ __('View product') }}
                                                </a>
                                            </div>
                                        </div>
                                        @if($item->variant->shipping_type === 'digital' && $item->shipmentItems->count())
                                            <div class="flex justify-center flex-1 pl-4">
                                                <button
                                                    wire:click="downloadDigitalAttachment({{ $item->variant->id }})"
                                                    type="button"
                                                    class="btn btn-link whitespace-nowrap"
                                                >
                                                    {{ __('Download') }}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 sm:hidden">
                                <div class="flex items-center pt-4 mt-6 space-x-4 text-sm font-medium border-t divide-x divide-slate-200 border-slate-200">
                                    <div class="flex justify-center flex-1">
                                        <a
                                            href="{{ route('guest.products.detail', $item->product) }}"
                                            class="btn btn-link whitespace-nowrap"
                                        >
                                            {{ __('View product') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="sm:ml-40 sm:pl-6">
                    <h3 class="sr-only">{{ __('Your information') }}</h3>

                    <h4 class="sr-only">{{ __('Addresses') }}</h4>
                    <dl class="grid grid-cols-2 py-10 text-sm gap-x-6">
                        <div>
                            <dt class="font-medium text-slate-900">{{ __('Shipping address') }}</dt>
                            <dd class="mt-2 text-slate-700">
                                <address class="not-italic">
                                    {{ $this->shippingAddress->name }}<br>

                                    @if($this->shippingAddress->company_name)
                                        {{ $this->shippingAddress->company_name }}<br>
                                    @endif

                                    @if($this->shippingAddress->address_line_1)
                                        {{ $this->shippingAddress->address_line_1 }}<br>
                                    @endif

                                    @if($this->shippingAddress->address_line_2)
                                        {{ $this->shippingAddress->address_line_2 }}<br>
                                    @endif

                                    @if($this->shippingAddress->city)
                                        {{ $this->shippingAddress->city }}
                                    @endif

                                    @if($this->shippingAddress->state)
                                        {{ $this->shippingAddress->state }}<br>
                                    @endif

                                    {{ $this->shippingAddress->country->name }}<br>

                                    @if($this->shippingAddress->phone)
                                        {{ $this->shippingAddress->phone }}<br>
                                    @endif
                                </address>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-900">{{ __('Billing address') }}</dt>
                            <dd class="mt-2 text-slate-700">
                                <address class="not-italic">
                                    {{ $this->billingAddress->name }}<br>

                                    @if($this->billingAddress->company_name)
                                        {{ $this->billingAddress->company_name }}<br>
                                    @endif

                                    @if($this->billingAddress->address_line_1)
                                        {{ $this->billingAddress->address_line_1 }}<br>
                                    @endif

                                    @if($this->billingAddress->address_line_2)
                                        {{ $this->billingAddress->address_line_2 }}<br>
                                    @endif

                                    @if($this->billingAddress->city)
                                        {{ $this->billingAddress->city }}
                                    @endif

                                    @if($this->billingAddress->state)
                                        {{ $this->billingAddress->state }}<br>
                                    @endif

                                    {{ $this->billingAddress->country->name }}<br>

                                    @if($this->billingAddress->phone)
                                        {{ $this->billingAddress->phone }}<br>
                                    @endif
                                </address>
                            </dd>
                        </div>
                    </dl>

                    <h4 class="sr-only">{{ __('Payment') }}</h4>
                    <dl class="grid grid-cols-2 py-10 text-sm border-t gap-x-6 border-slate-200">
                        <div>
                            <dt class="font-medium text-slate-900">{{ __('Payment method') }}</dt>
                            <dd class="mt-2 text-slate-700">
                                <p>{{ $order->paymentMethod->name }}</p>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-900">{{ __('Shipping method') }}</dt>
                            <dd class="mt-2 text-slate-700">
                                <p>{{ $order->shipping_rate }}</p>
                            </dd>
                        </div>
                    </dl>

                    <h3 class="sr-only">{{ __('Summary') }}</h3>

                    <dl class="pt-10 space-y-6 text-sm border-t border-slate-200">
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-900">{{ __('Subtotal') }}</dt>
                            <dd class="text-slate-700">
                                <x-money
                                    :amount="$order->subtotal"
                                    :currency="config('app.currency')"
                                />
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="flex font-medium text-slate-900">{{ __('Discount') }}</dt>
                            <dd class="text-slate-700">
                                <x-money
                                    :amount="$order->discount_total"
                                    :currency="config('app.currency')"
                                />
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-900">{{ __('Shipping') }}</dt>
                            <dd class="text-slate-700">
                                <x-money
                                    :amount="$order->shipping_price"
                                    :currency="config('app.currency')"
                                />
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-900">{{ __('Tax') }}</dt>
                            <dd class="text-slate-700">
                                <x-money
                                    :amount="$order->tax_total"
                                    :currency="config('app.currency')"
                                />
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-900">{{ __('Total') }}</dt>
                            <dd class="text-slate-900">
                                <x-money
                                    :amount="$order->total"
                                    :currency="config('app.currency')"
                                />
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
