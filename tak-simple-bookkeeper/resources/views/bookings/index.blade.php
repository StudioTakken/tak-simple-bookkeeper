<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ ucfirst(Session::get('viewscope')) }}
            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="py-6">


        {{-- <a href="{{ route('bookings.create') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Create</span>
            </x-button>
        </a> --}}

        @livewire(
            'admin-bookings',
            [
                'method' => $method,
                'include_children' => $include_children,
            ],
            key(now() . '-' . Str::random())
        )
        @livewire('side-panel', [], key(key(now()) . '-' . Str::random()))



    </div>
</x-app-layout>
