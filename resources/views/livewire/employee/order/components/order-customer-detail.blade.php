<div>
    <x-card>
        <x-slot:header>
            <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                {{ __('Customer') }}
            </h3>
        </x-slot:header>
        <x-slot:content>
            <div
                class="-m-6 -mx-4 border-t divide-y border-slate-200 divide-slate-200 sm:-mx-6 dark:border-slate-200/10 dark:divide-slate-200/10">
                @if($order->customer)
                <div class="flex items-center p-4 sm:py-5 sm:px-6">
                    <div class="flex-shrink-0 mr-4">
                        <img src="{{ $order->customer->getFirstMediaUrl('avatar') }}" alt="{{ $order->customer->name }}"
                            class="object-cover object-center w-10 h-10 rounded-full bg-slate-200">
                    </div>
                    <div class="flex items-center justify-between w-full">
                        <a href="{{ route('employee.customers.detail', $order->customer) }}"
                            class="text-sm font-medium hover:text-sky-600 dark:hover:text-sky-400">
                            {{ $order->customer->name }}
                        </a>
                        <x-heroicon-s-chevron-right class="w-5 h-5 text-slate-400" />
                    </div>
                </div>
                <div class="p-4 text-sm sm:py-5 sm:px-6">
                    <h4 class="text-xs font-medium uppercase">
                        {{ __('Contact information') }}
                    </h4>
                    <ul class="mt-3 space-y-1">
                        <li @class(['text-slate-500 dark:text-slate-400'=> !$order->customer->email])>
                            {{ $order->customer->email ?? __('No email provided') }}
                        </li>
                        <li @class(['text-slate-500 dark:text-slate-400'=> !$order->customer->phone])>
                            {{ $order->customer->phone ?? __('No phone number') }}
                        </li>
                    </ul>
                </div>
                @endif

                @if($order->shippingAddress)
                <div class="p-4 sm:py-5 sm:px-6">
                    <h4 class="text-xs font-medium uppercase">
                        {{ __('Shipping address') }}
                    </h4>
                    <address class="mt-2 text-sm not-italic">
                        {{ $order->shippingAddress->name }}<br>

                        @if($order->shippingAddress->company_name)
                        {{ $order->shippingAddress->company_name }}<br>
                        @endif

                        @if($order->shippingAddress->address_line_1)
                        {{ $order->shippingAddress->address_line_1 }}<br>
                        @endif

                        @if($order->shippingAddress->address_line_2)
                        {{ $order->shippingAddress->address_line_2 }}<br>
                        @endif

                        @if($order->shippingAddress->city)
                        {{ $order->shippingAddress->city }}
                        @endif

                        @if($order->shippingAddress->state)
                        {{ $order->shippingAddress->state }}<br>
                        @endif

                        {{ $order->shippingAddress->country->name }}<br>

                        @if($order->shippingAddress->phone)
                        {{ $order->shippingAddress->phone }}<br>
                        @endif
                    </address>
                </div>
                @endif

                @if($order->billingAddress)
                <div class="p-4 sm:py-5 sm:px-6">
                    <h4 class="text-xs font-medium uppercase">
                        {{ __('Billing address') }}
                    </h4>
                    <address class="mt-2 text-sm not-italic">
                        {{ $order->billingAddress->name }}<br>

                        @if($order->billingAddress->company_name)
                        {{ $order->billingAddress->company_name }}<br>
                        @endif

                        @if($order->billingAddress->address_line_1)
                        {{ $order->billingAddress->address_line_1 }}<br>
                        @endif

                        @if($order->billingAddress->address_line_2)
                        {{ $order->billingAddress->address_line_2 }}<br>
                        @endif

                        @if($order->billingAddress->city)
                        {{ $order->billingAddress->city }}
                        @endif

                        @if($order->billingAddress->state)
                        {{ $order->billingAddress->state }}<br>
                        @endif

                        {{ $order->billingAddress->country->name }}<br>

                        @if($order->billingAddress->phone)
                        {{ $order->billingAddress->phone }}<br>
                        @endif
                    </address>
                </div>
                @endif
            </div>
        </x-slot:content>
    </x-card>
</div>