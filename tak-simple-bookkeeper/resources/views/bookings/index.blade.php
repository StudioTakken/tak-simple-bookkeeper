<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ ucfirst($scope) }}
            </h2>
        </div>
    </x-slot>

    @livewire('date-settings')

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="py-6">


        <button x-data @click="alert('I\'ve been clicked!')">Click Me</button>

        <a href="{{ route('bookings.import') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Import</span>
            </x-button>
        </a>


        {{-- <a href="{{ route('bookings.create') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Create</span>
            </x-button>
        </a> --}}

        @livewire('admin-bookings', ['scope' => $scope], key(now() . '-' . Str::random()))




    </div>
</x-app-layout>
