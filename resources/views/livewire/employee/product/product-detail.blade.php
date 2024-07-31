<div>
    <!-- Meta title & description -->
    <x-slot:title>
        {{ __('Products - :name', ['name' => $product->name]) }}
    </x-slot:title>

    <!-- Page title & actions -->
    <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex items-center flex-1 min-w-0 space-x-2">
            <a href="{{ route('employee.products.list') }}" class="btn btn-default btn-xs">
                <x-heroicon-m-arrow-left class="w-5 h-5" />
            </a>
            <h1 class="text-2xl font-medium truncate text-slate-900 dark:text-slate-100">
                {{ $product->name }}
            </h1>
            <x-badge :type="$product->is_active ? 'success' : 'default'">
                {{ $product->status->label() }}
            </x-badge>
        </div>
        <div class="flex mt-4 sm:mt-0 sm:ml-4">
            <a href="{{ route('guest.products.detail', $product->slug) }}" target="_blank"
                class="w-full btn btn-outline-primary">
                {{ __('Preview') }}
            </a>
        </div>
    </div>

    <!-- Page content -->
    <div class="p-4 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 space-y-6 xl:col-span-2">
                <livewire:employee.product.components.product-information :product="$product" />

                <livewire:employee.product.components.product-specification :product="$product" />

                <livewire:employee.product.components.product-gallery :product="$product" />

                @unless($product_options_count)
                <livewire:employee.product.components.product-variant-pricing :product="$product"
                    :variant="$product->variants->first()" />

                <livewire:employee.product.components.product-variant-inventory :product="$product"
                    :variant="$product->variants->first()" />

                <livewire:employee.product.components.product-variant-shipping :product="$product"
                    :variant="$product->variants->first()" />
                @endunless

                <livewire:employee.product.components.product-option :product="$product" />

                @if($product_options_count > 0)
                <livewire:employee.product.components.product-variant-list :product="$product" />
                @endif

                <livewire:employee.search-engine-information-form :model="$product" />
            </div>

            <div class="col-span-3 space-y-6 xl:col-span-1">
                <livewire:employee.product.components.product-status :product="$product" />

                <livewire:employee.product.components.product-organization :product="$product" />
            </div>
        </div>
    </div>
</div>