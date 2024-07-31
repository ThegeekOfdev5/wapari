<div>
    <x-slot:title>
        {!! $page->title !!}
    </x-slot:title>

    <div class="px-4 py-4 bg-white sm:py-8 sm:px-2">
        <div class="max-w-3xl mx-auto text-base leading-7 text-gray-700">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ $page->title }}
            </h1>
            <div class="mt-6 prose prose-slate max-w-none dark:prose-dark">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
