<x-app-layout>
    <x-slot name="header">
        <div class="flex w-9/12">

            <div class="flex-none">
                <h2 class="text-xl font-semibold leading-tight">
                    {{ ucfirst(Session::get('viewscope')) }}
                </h2>
            </div>
            <div class="flex-grow"></div>
            <div class="flex-none">
                @if (isset($account))
                    <a href="{{ route('accounts.edit', $account->id) }}"
                        class="inline-flex items-center px-2 py-1 text-sm text-white transition duration-150 ease-in-out bg-gray-400 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                        Edit {{ $account->name }} settings
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="py-6">

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
