<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ ucfirst($scope) }}
            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="py-6">


        @livewire('admin-edit-booking', ['booking' => $booking], key(key(now()) . '-' . Str::random()))


    </div>
</x-app-layout>
