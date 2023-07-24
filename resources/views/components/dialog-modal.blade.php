@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>

    <div class="px-6 py-4 bg-black">
        <div class="text-2xl">
            {{ $title }}
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-900">
        <div class="mt-4">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-black text-right">
        {{ $footer }}
    </div>

</x-modal>
