@props(['wrapperClasses' => ''])

<div x-data
    class="relative text-slate-500 {{ $wrapperClasses }} focus-within:text-slate-600 dark:focus-within:text-slate-200">
    <div class="absolute inset-y-0 left-0 flex items-center px-3 mr-4 pointer-events-none">
        <span class="sm:text-sm">
            {{ config('money.'.config('app.currency').'.symbol') }}
        </span>
    </div>

    <x-input type="text"
        x-mask:dynamic="$money($input, '{{ config('money.'.config('app.currency').'.decimal_mark') }}')" {{
        $attributes->merge(['class' => 'pl-14']) }}
        />
</div>
