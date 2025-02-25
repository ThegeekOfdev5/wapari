<div>
    <x-card>
        <x-slot:header>
            <h2 class="text-xl font-medium leading-6 text-slate-900 dark:text-slate-100">
                {{ __('Last order placed') }}
            </h2>
        </x-slot:header>
        <x-slot:content class="-mt-5">
            @unless($customer->orders->count())
                <p class="text-slate-500 sm:text-sm dark:text-slate-400">{{ __('This customer hasn’t placed any orders yet.') }}</p>
            @else
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <h2>
                            <a
                                href="{{ route('employee.orders.detail', ['order' => $customer->orders->last()->id]) }}"
                                class="btn btn-link"
                            >
                                {{ $customer->orders->last()->id }}
                            </a>
                        </h2>
                        <div class="flex items-center space-x-1 text-sm text-slate-500 dark:text-slate-400">
                        <span
                            class="block w-2 h-2 rounded-full"
                            style="background-color: {{ $customer->orders->last()->payment_status->color() }}"
                        ></span>
                            <span>{{ $customer->orders->last()->payment_status->label() }}</span>
                        </div>
                        <div class="flex items-center space-x-1 text-sm text-slate-500 dark:text-slate-400">
                        <span
                            class="block w-2 h-2 rounded-full"
                            style="background-color: {{ $customer->orders->last()->shipping_status->color() }}"
                        ></span>
                            <span>{{ $customer->orders->last()->shipping_status->label() }}</span>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $customer->orders->last()->created_at->toDayDateTimeString() }}
                        </p>
                    </div>
                </div>

                <div class="sm:hidden">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ $customer->orders->last()->created_at->toDayDateTimeString() }}
                    </p>
                </div>

                <div class="relative mt-5 -mx-4 overflow-auto sm:-mx-6">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                        <thead class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-left uppercase sm:px-6 text-slate-500 dark:text-slate-400"
                                >
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-center uppercase sm:px-6 text-slate-500 dark:text-slate-400"
                                >
                                    {{ __('QTY') }}
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400"
                                >
                                    {{ __('Price') }}
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400"
                                >
                                    {{ __('Subtotal') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                            @foreach($customer->orders->last()->orderItems as $item)
                                <tr>
                                    <td class="w-full max-w-sm px-3 py-4 text-sm sm:px-6 text-slate-500 dark:text-slate-400">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <img
                                                    class="object-cover object-center w-10 h-10 rounded"
                                                    src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image', 'thumb') : $item->variant->product->getFirstMediaUrl('gallery', 'thumb') }}"
                                                    alt="{{ $item->name }}"
                                                >
                                            </div>
                                            <div class="flex flex-col max-w-xs ml-4">
                                                <div class="font-medium text-slate-900 hover:text-sky-600 truncate ... dark:text-slate-200 dark:hover:text-sky-400">
                                                    <a href="{{ route('employee.products.detail', $item->variant->product) }}">{{ $item->name }}</a>
                                                </div>
                                                @if($item->variant->variantAttributes)
                                                    <ul class="space-x-2 divide-x divide-slate-200 text-slate-500 dark:divide-slate-200/10 dark:text-slate-400">
                                                        @foreach($item->variant->variantAttributes as $attribute)
                                                            <li @class(['inline', 'pl-2' => !$loop->first])>{{ $attribute->optionValue->label }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-center sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                        {{ $item->quantity - $item->shipment_items_sum_quantity }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                        <x-money :amount="$item->price" :currency="config('app.currency')"/>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                        <x-money :amount="$item->subtotal" :currency="config('app.currency')"/>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endunless
        </x-slot:content>
    </x-card>
</div>
