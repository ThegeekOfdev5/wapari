@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium leading-6 font-display text-slate-900 dark:text-slate-200" id="modal-title">
            {{ $title }}
        </h3>
        <button x-on:click="show = false" type="button"
            class="flex items-center space-x-1 transition-opacity opacity-50 hover:opacity-80">
            <x-heroicon-m-x-mark class="w-4" />
            <span class="text-xs font-medium tracking-wider uppercase">{{ __('Close') }}</span>
        </button>
    </div>
    <div class="mt-4">
        <p class="text-sm text-slate-500 dark:text-slate-200">
            {{ $content }}
        </p>
    </div>
    @isset($footer)
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
        {{ $footer }}
    </div>
    @endif
</x-modal>
