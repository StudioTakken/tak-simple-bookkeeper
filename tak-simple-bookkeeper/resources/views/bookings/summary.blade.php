<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Summary periode: {{ Session::get('startDate') }} - {{ Session::get('stopDate') }}
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
            <a href="{{ route('summary.filter', 'inout') }}">In en Uit</a>
        </button>
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary.filter', 'venw') }}">Verlies en Winst</a>
        </button>
        <button class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
            <a href="{{ route('summary.filter', 'btw') }}">BTW overzicht</a>
        </button>
    </div>




    <div class="py-6">

        <div class="flex items-start w-4/6 grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @if (isset($summery['debet']))
                    @foreach ($summery['debet'] as $key => $item)
                        <div>
                            {{ $item['name'] }}
                        </div>
                        <div class='font-mono text-right'>
                            {{ $item['debet'] }}
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @if (isset($summery['credit']))
                    @foreach ($summery['credit'] as $key => $item)
                        <div>
                            {{ $item['name'] }}
                        </div>
                        <div class='font-mono text-right'>
                            {{ $item['credit'] }}
                        </div>
                    @endforeach
                @endif
            </div>

        </div>


        {{-- here the divs for the totals --}}
        <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-8 font-bold">

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='font-mono text-right'>
                    {{ $totals['debet'] }}
                </div>


            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='font-mono text-right'>
                    {{ $totals['credit'] }}
                </div>


            </div>

        </div>




    </div>
</x-app-layout>
