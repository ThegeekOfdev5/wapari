<div @class(['space-y-6'=> $physicalItems->count() || $digitalItems->count(), '-mt-6' => !$physicalItems->count() &&
    !$digitalItems->count()])>
    @if($physicalItems->count())
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                <div class="mt-2 ml-4">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Unshipped') }}
                    </h3>
                </div>
                <div class="flex-shrink-0 mt-2 ml-4">
                    <a href="{{ route('employee.orders.shipments.create', ['order' => $order, 'type' => 'physical']) }}"
                        class="btn btn-link">
                        {{ __('Create shipment') }}
                    </a>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mx-4 -mt-5 sm:-mx-6">
            <div class="-mb-5 space-y-6">
                <div class="relative overflow-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                        <thead
                            class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-left uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-center uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('QTY') }}
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('Price') }}
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('Subtotal') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                            @foreach($physicalItems as $item)
                            <tr>
                                <td
                                    class="w-full max-w-sm px-3 py-4 text-sm sm:px-6 text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="object-cover object-center w-10 h-10 rounded"
                                                src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image', 'thumb') : $item->variant->product->getFirstMediaUrl('gallery', 'thumb') }}"
                                                alt="{{ $item->name }}">
                                        </div>
                                        <div class="flex flex-col max-w-xs ml-4">
                                            <div
                                                class="font-medium text-slate-900 hover:text-sky-600 truncate ... dark:text-slate-200 dark:hover:text-sky-400">
                                                <a
                                                    href="{{ route('employee.products.detail', $item->variant->product) }}">{{
                                                    $item->name }}</a>
                                            </div>
                                            @if($item->variant->variantAttributes)
                                            <ul
                                                class="space-x-2 divide-x divide-slate-200 text-slate-500 dark:divide-slate-200/10 dark:text-slate-400">
                                                @foreach($item->variant->variantAttributes as $attribute)
                                                <li @class(['inline', 'pl-2'=> !$loop->first])>{{
                                                    $attribute->optionValue->label }}</li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            @if($item->discount)
                                            <ul class="list-disc list-inside">
                                                <li>{{ __(':discountCode discount applied', ['discountCode' =>
                                                    $item->discount->code]) }}</li>
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-center sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    {{ $item->quantity - ($item->total_shipped + $item->total_removed +
                                    $item->total_shipped_refunded) }}
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    @if($item->discount)
                                    <span class="block text-xs line-through">
                                        <x-money :amount="$item->price" :currency="config('app.currency')" />
                                    </span>
                                    <x-money
                                        :amount="$item->discount->type === 'fixed' ? $item->price - $item->discount->amount : $item->price - ($item->price * $item->discount->amount / 100)"
                                        :currency="config('app.currency')" />
                                    @else
                                    <x-money :amount="$item->price" :currency="config('app.currency')" />
                                    @endif
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    <x-money
                                        :amount="$item->price * ($item->quantity - ($item->total_shipped + $item->total_removed + $item->total_shipped_refunded)) - $item->discount?->discounted_amount"
                                        :currency="config('app.currency')" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-slot:content>
    </x-card>
    @endif

    @if($digitalItems->count())
    <x-card class="-mx-4 overflow-hidden sm:-mx-0">
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                <div class="mt-2 ml-4">
                    <h3 class="text-base font-medium text-slate-900 dark:text-slate-200">
                        {{ __('Unshipped') }}
                    </h3>
                </div>
                <div class="flex-shrink-0 mt-2 ml-4">
                    <a href="{{ route('employee.orders.shipments.create', ['order' => $order, 'type' => 'digital']) }}"
                        class="btn btn-link">
                        {{ __('Create shipment') }}
                    </a>
                </div>
            </div>
        </x-slot:header>
        <x-slot:content class="-mx-4 -mt-5 sm:-mx-6">
            <div class="-mb-5 space-y-6">
                <div class="relative overflow-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-200/10">
                        <thead
                            class="border-t border-slate-200 bg-slate-50 dark:border-slate-200/10 dark:bg-slate-800/75">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-left uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-center uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('QTY') }}
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('Price') }}
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-xs font-medium tracking-wider text-right uppercase sm:px-6 text-slate-500 dark:text-slate-400">
                                    {{ __('Subtotal') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-200/10">
                            @foreach($digitalItems as $item)
                            <tr>
                                <td
                                    class="w-full max-w-sm px-3 py-4 text-sm sm:px-6 text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="object-cover object-center w-10 h-10 rounded"
                                                src="{{ $item->variant->hasMedia('image') ? $item->variant->getFirstMediaUrl('image', 'thumb') : $item->variant->product->getFirstMediaUrl('gallery', 'thumb') }}"
                                                alt="{{ $item->name }}">
                                        </div>
                                        <div class="flex flex-col max-w-xs ml-4">
                                            <div
                                                class="font-medium text-slate-900 hover:text-sky-600 truncate ... dark:text-slate-200 dark:hover:text-sky-400">
                                                <a
                                                    href="{{ route('employee.products.detail', $item->variant->product) }}">{{
                                                    $item->name }}</a>
                                            </div>
                                            @if($item->variant->variantAttributes)
                                            <ul
                                                class="space-x-2 divide-x divide-slate-200 text-slate-500 dark:divide-slate-200/10 dark:text-slate-400">
                                                @foreach($item->variant->variantAttributes as $attribute)
                                                <li @class(['inline', 'pl-2'=> !$loop->first])>{{
                                                    $attribute->optionValue->label }}</li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            @if($item->discount)
                                            <ul class="list-disc list-inside">
                                                <li>{{ __(':discountCode discount applied', ['discountCode' =>
                                                    $item->discount->code]) }}</li>
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-center sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    {{ $item->quantity - ($item->shipment_items_sum_quantity + $item->total_removed) }}
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    @if($item->discount)
                                    <span class="block text-xs line-through">
                                        <x-money :amount="$item->price" :currency="config('app.currency')" />
                                    </span>
                                    <x-money
                                        :amount="$item->discount->type === 'fixed' ? $item->price - $item->discount->amount : $item->price - ($item->price * $item->discount->amount / 100)"
                                        :currency="config('app.currency')" />
                                    @else
                                    <x-money :amount="$item->price" :currency="config('app.currency')" />
                                    @endif
                                </td>
                                <td
                                    class="px-3 py-4 text-sm text-right sm:px-6 whitespace-nowrap text-slate-500 tabular-nums dark:text-slate-400">
                                    <x-money
                                        :amount="$item->price * ($item->quantity - ($item->shipment_items_sum_quantity + $item->refund_items_sum_quantity)) - $item->discount?->discounted_amount"
                                        :currency="config('app.currency')" />
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"
                                    class="w-full max-w-sm px-3 py-4 text-sm sm:px-6 whitespace-nowrap text-slate-500 dark:text-slate-400">
                                    {{ __('Shipping not required.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </x-slot:content>
    </x-card>
    @endif
</div>