@push('after-script')
    @vite('resources/js/vuejs/products/app.js')
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="pt-12" id="products"></div>
</x-app-layout>
