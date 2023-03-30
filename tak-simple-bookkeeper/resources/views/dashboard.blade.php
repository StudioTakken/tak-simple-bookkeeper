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
            Begin met het <a class="text-takred-500" href="{{ route('importing') }}">importeren van je bank csv
                bestand</a>.<br />
            Daarna in het handig een <a class="text-takred-500" href="{{ route('importing') }}">debiteuren excel bestand
                te importeren</a>.<br />
        </div>

        <div class="grid grid-cols-2 mt-5 text-sm">


            <div>
                <div class="font-bold">
                    We have these accounts:<br /><br />
                </div>

                <ul>
                    @foreach ($accounts as $account)
                        <li class="py-1"><a class="py-2 text-takred-500"
                                href="{{ route('account.onaccount', ['account' => $account->slug]) }}">{{ $account->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-5">
                    <button class="settingsbutton soft">
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
                        <li class="py-1"><a class=" text-takred-500"
                                href="{{ route('category.oncategory', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>




                <div class="mt-5">
                    <button class="settingsbutton soft">
                        <a href="{{ route('category.create') }}">Add a category</a>
                    </button>
                    </button>
                </div>
            </div>

        </div>


    </div>


    <div class="text-xs sticky top-[100vh]">
        {{ config('app.name') }} Version: {{ config('app.version') }}
    </div>
</x-app-layout>
