@push('after-script')
    @vite('resources/js/vuejs/categories/app.js')
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12" id="categories"></div>
</x-app-layout>
