<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Balans
            </h2>
        </div>
    </x-slot>



    <div class="w-full py-6">

        <div class="flex items-start w-full grid-cols-2 gap-8 mb-4">

            <div class="grid w-1/2 grid-cols-3 gap-4 font-bold">

                <div class="">
                    Account
                </div>
                <div class='text-right '>
                    {{ $start }}
                </div>
                <div class='text-right '>
                    {{ $stop }}
                </div>

            </div>

        </div>



        <div class="flex items-start w-full grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-3 gap-4">
                @foreach ($balance as $key => $details)
                    <div>
                        {{ $details['name'] }}
                    </div>
                    <div class='font-mono text-right'>

                        {{ number_format($details['start'] / 100, 2, ',', '.') }}
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($details['end'] / 100, 2, ',', '.') }}
                    </div>
                @endforeach
            </div>

        </div>


        <div class="flex items-start w-full grid-cols-2 gap-8 mt-5 font-bold">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    Totals
                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['start'] / 100, 2, ',', '.') }}
                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['end'] / 100, 2, ',', '.') }}
                </div>

            </div>

        </div>








        <div class="flex items-start w-full grid-cols-2 gap-8 mt-20 font-bold">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    Resultaat
                </div>
                <div class='font-mono text-right'>

                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['result'] / 100, 2, ',', '.') }}
                </div>

            </div>

        </div>

        <div class="flex items-start w-full grid-cols-2 gap-8 mt-2 ">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    - Nog af te dragen BTW
                </div>
                <div class='font-mono text-right'>

                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['btw_afdracht'] / 100, 2, ',', '.') }}
                </div>

            </div>

        </div>


        <div class="flex items-start w-full grid-cols-2 gap-8 mt-2 ">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    + Prive opname en belasting
                </div>
                <div class='font-mono text-right'>

                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['prive'] / 100, 2, ',', '.') }}
                </div>

            </div>

        </div>


        <div class="flex items-start w-full grid-cols-2 gap-8 mt-2 font-bold">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    Winst
                </div>
                <div class='font-mono text-right'>

                </div>
                <div class='font-mono text-right'>
                    {{ number_format($balancetotals['winst'] / 100, 2, ',', '.') }}
                </div>

            </div>

        </div>



        <div class="mt-5">
            <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
                <a href="{{ route('balance-xlsx') }}">
                    Download als xls bestand
                </a>
            </button>
        </div>


</x-app-layout>
