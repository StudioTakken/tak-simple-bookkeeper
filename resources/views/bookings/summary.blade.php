<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Overzicht periode: {{ Session::get('startDate') }} - {{ Session::get('stopDate') }}
            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="py-6">
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary.filter', 'venw') }}">Verlies en Winst</a>
        </button>
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary.filter', 'btw') }}">BTW overzicht</a>
        </button>
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary.filter', 'inout') }}">In en Uit</a>
        </button>
    </div>




    <div class="py-6">

        <div class="flex items-start w-4/6 grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @if (isset($summary['debet']))
                    @foreach ($summary['debet'] as $key => $item)
                        <div>
                            {{ $item['name'] }}
                        </div>
                        <div class='font-mono text-right'>

                            {{ number_format($item['debet'] / 100, 2, ',', '.') }}
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @if (isset($summary['credit']))
                    @foreach ($summary['credit'] as $key => $item)
                        <div>
                            {{ $item['name'] }}
                        </div>
                        <div class='font-mono text-right'>
                            {{ number_format($item['credit'] / 100, 2, ',', '.') }}
                        </div>
                    @endforeach
                @endif
            </div>

        </div>


        {{-- here the divs for the totals --}}
        <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-8 font-bold">
            <div class="grid w-1/2 grid-cols-2 gap-4">
                <div>
                    Totaal In
                </div>
                <div class='font-mono text-right'>
                    {{ number_format($summary['totals']['debet'] / 100, 2, ',', '.') }}
                </div>
            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">
                <div>
                    Totaal Uit
                </div>
                <div class='font-mono text-right'>
                    {{ number_format($summary['totals']['credit'] / 100, 2, ',', '.') }}
                </div>
            </div>

        </div>



        @if (session()->get('filter') == 'venw')
            <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-16 font-bold">
                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>
                        Winst
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['result'] / 100, 2, ',', '.') }}
                    </div>
                </div>
            </div>




            <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-16">
                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>
                        Per maand ongeveer
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['resultPerMonth'] / 100, 2, ',', '.') }}
                    </div>
                </div>
            </div>


            <div class="flex items-start w-4/6 grid-cols-2 gap-8">
                <div class="grid w-1/2 grid-cols-2">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2">
                    <div>
                        Per jaar ongeveer
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['resultPerYear'] / 100, 2, ',', '.') }}
                    </div>
                </div>
            </div>
        @endif





        @if (session()->get('filter') == 'btw')
            <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-16 font-bold">
                <div class="grid w-1/2 grid-cols-2">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2">
                    <div>
                        BTW op inkomsten (21%)
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['nBtwDebet'] / 100, 2, ',', '.') }}
                    </div>
                </div>

            </div>

            @if ($summary['totals']['nBtwDebet9'] > 0)
                <div class="flex items-start w-4/6 grid-cols-2 gap-8 font-bold">
                    <div class="grid w-1/2 grid-cols-2">
                        <div>

                        </div>
                        <div class='font-mono text-right'>

                        </div>
                    </div>

                    <div class="grid w-1/2 grid-cols-2">
                        <div>
                            BTW op inkomsten (9%)
                        </div>
                        <div class='font-mono text-right'>
                            {{ number_format($summary['totals']['nBtwDebet9'] / 100, 2, ',', '.') }}
                        </div>
                    </div>

                </div>
            @endif

            <div class="flex items-start w-4/6 grid-cols-2 gap-8 font-bold">
                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>
                        Voorbelasting
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['nBtwCredit'] / 100, 2, ',', '.') }}
                    </div>
                </div>

            </div>

            <div class="flex items-start w-4/6 grid-cols-2 gap-8 font-bold">
                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>

                    </div>
                    <div class='font-mono text-right'>

                    </div>
                </div>

                <div class="grid w-1/2 grid-cols-2 gap-4">
                    <div>
                        Af te dragen
                    </div>
                    <div class='font-mono text-right'>
                        {{ number_format($summary['totals']['nBtwVerschil'] / 100, 2, ',', '.') }}
                    </div>
                </div>

            </div>
        @endif














    </div>

    <div class="mt-5">
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary-xlsx.filter', session()->get('filter')) }}">
                Download als xls bestand
            </a>
        </button>

    </div>



</x-app-layout>
