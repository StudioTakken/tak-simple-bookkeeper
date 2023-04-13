<x-app-layout>
    <x-slot name="header">
        <div class="flex w-9/12">

            <div class="flex-none">
                <h2 class="text-xl font-semibold leading-tight">


                    @if (isset($account))
                        {{ $account->name }}
                    @endif

                    @if (isset($category))
                        {{ $category->name }}
                    @endif


                </h2>
            </div>
            <div class="flex-grow"></div>
            <div class="flex-none">
                @if (isset($account))
                    <button class="settingsbutton soft">
                        <a href="{{ route('accounts.edit', $account->id) }}">
                            Edit account: {{ $account->name }} settings
                        </a>
                    </button>
                @endif

                @if (isset($category))
                    <button class="settingsbutton soft">
                        <a href="{{ route('categories.edit', $category->id) }}">
                            Edit categorie: {{ $category->name }} settings
                        </a>
                    </button>
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




        @if (isset($account))
            <div>
                @livewire('booking-create', ['account' => $account], key(now() . '-|-' . Str::random()))
            </div>
        @endif




        <div>

            @livewire(
                'admin-bookings',
                [
                    'method' => $method,
                    'include_children' => $include_children,
                ],
                key(now() . '-' . Str::random())
            )

        </div>

        <div class="mt-5">
            <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
                <a href="{{ route('bookings-xlsx') }}">
                    Download als xls bestand
                </a>
            </button>
        </div>




        <div>

            @livewire('side-panel', [], key(key(now()) . '-' . Str::random()))

        </div>


    </div>
</x-app-layout>
