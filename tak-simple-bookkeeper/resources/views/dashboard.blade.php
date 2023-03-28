<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            {{-- <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button> --}}
        </div>
    </x-slot>

    <div class="overflow-hidden bg-white ">


        <div class="text-sm">
            We houden het zo eenvoudig mogelijk.<br />
            Begin met het importeren van je bank csv bestand.<br />
            Daarna in het handig een debiteuren excel bestand te importeren.<br />
        </div>

        <div class="grid grid-cols-2 mt-5 text-sm">


            <div>
                <div class="font-bold">
                    We have these accounts:<br /><br />
                </div>

                <ul>
                    @foreach ($accounts as $account)
                        <li>{{ $account->name }}</li>
                    @endforeach
                </ul>

                <div class="mt-5">
                    <button class="text-white btn bg-takgreen-500 btn-small">
                        <a href="{{ route('account.create') }}">Add an account</a>
                    </button>
                </div>

            </div>

            <div>
                <div class="font-bold">
                    We have these categories:<br /><br />
                </div>

                <ul>
                    @foreach ($categories as $category)
                        <li>{{ $category->name }}</li>
                    @endforeach
                </ul>




                <div class="mt-5">
                    <button class="text-white btn bg-takgreen-500 btn-small">
                        Add a category</button>
                    </button>
                </div>
            </div>

        </div>


    </div>
</x-app-layout>
