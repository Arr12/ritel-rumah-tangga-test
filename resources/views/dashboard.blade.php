@push('after-script')
    @vite('resources/js/vuejs/dashboard/app.js')
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="md:px-12 py-12" id="dashboard"></div>
</x-app-layout>
