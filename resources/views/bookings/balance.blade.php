<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Balans
            </h2>
        </div>
    </x-slot>


    <table class="w-3/4 border-0 border-separate border-spacing-4">

        <tr class="font-bold ">
            <td>Account</td>
            <td colspan="2" class='m-2 font-mono text-center border-b-2'>Debet</td>
            <td colspan="2" class='m-2 font-mono text-center border-b-2'>Credit</td>
        </tr>

        <tr class="font-bold ">
            <td class='font-mono text-right'></td>
            <td class='font-mono text-right'> {{ $start }}</td>
            <td class='font-mono text-right'> {{ $stop }}</td>
            <td class='font-mono text-right'> {{ $start }}</td>
            <td class='font-mono text-right'> {{ $stop }}</td>
        </tr>

        @foreach ($balance as $key => $details)
            <tr>
                <td>{{ $details['name'] }}</td>
                <td class='font-mono text-right'>
                    @if ($details['polarity'] == '1')
                        {{ number_format($details['start'] / 100, 2, ',', '.') }}
                    @endif
                </td>
                <td class='font-mono text-right'>
                    @if ($details['polarity'] == '1')
                        {{ number_format($details['end'] / 100, 2, ',', '.') }}
                    @endif
                </td>
                <td class='font-mono text-right'>
                    @if ($details['polarity'] == '-1')
                        {{ number_format($details['start'] / 100, 2, ',', '.') }}
                    @endif
                </td>
                <td class='font-mono text-right'>
                    @if ($details['polarity'] == '-1')
                        {{ number_format($details['end'] / 100, 2, ',', '.') }}
                    @endif
                </td>
            </tr>
        @endforeach


        {{-- 
        
        @TODO Hier ben ik nog niet uit

        <tr>
            <td>Nog af te dragen BTW</td>
            <td class='font-mono text-right'>

            </td>
            <td class='font-mono text-right'>
            </td>
            <td class='font-mono text-right'>
                7654321

            </td>
            <td class='font-mono text-right'>

                1234567

            </td>
        </tr>
--}}

        <tr>
            <td>Eigen vermogen</td>
            <td class='font-mono text-right'>

            </td>
            <td class='font-mono text-right'>

            </td>
            <td class='font-mono text-right'>
                {{ number_format($balancetotals['startEigenVermogen'] / 100, 2, ',', '.') }}
            </td>
            <td class='font-mono text-right'>

                {{ number_format($balancetotals['endEigenVermogen'] / 100, 2, ',', '.') }}

            </td>
        </tr>




        <tr class="font-bold">
            <td class='font-mono'>Totals</td>
            <td class='font-mono text-right border-t-2'>
                {{ number_format($balancetotals['startDebet'] / 100, 2, ',', '.') }}
            </td>
            <td class='font-mono text-right border-t-2'>
                {{ number_format($balancetotals['endDebet'] / 100, 2, ',', '.') }}
            </td>
            <td class='font-mono text-right border-t-2'>
                {{ number_format($balancetotals['startChecksum'] / 100, 2, ',', '.') }}
            </td>
            <td class='font-mono text-right border-t-2'>
                {{ number_format($balancetotals['endChecksum'] / 100, 2, ',', '.') }}
            </td>
        </tr>





    </table>








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
