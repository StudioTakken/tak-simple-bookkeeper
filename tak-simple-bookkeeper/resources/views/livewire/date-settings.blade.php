<div class="flex gap-3 items-left">
    <div class="flex flex-row">

        <input class="py-0 border-gray-400" type="date" wire:model="startDate" id="startDate" name="startDate">
        <input class="py-0 border-gray-400" type="date" wire:model="stopDate" id="stopDate" name="stopDate">

        <div class="flex flex-col p-0 m-0">
        </div>
        <div class="flex flex-col">
        </div>

        <div class="flex flex-col mx-1 my-1 ml-4">
            <button class="btn btn-gray-500 btn-small" wire:click="lastYear">Vorig jaar</button>
        </div>
        <div class="flex flex-col mx-1 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="thisYear">Dit jaar</button>
        </div>
        <div class="flex flex-col mx-1 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="lastQuarter">Vorig kwartaal</button>
        </div>
        <div class="flex flex-col mx-1 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="thisQuarter">Dit kwartaal</button>
        </div>

        <div>

            <div class="relative inline-block dropdown">
                <button class="inline-flex items-center px-4 py-1 font-semibold text-gray-700 bg-gray-300 rounded">
                    <span class="mr-1">Maanden</span>
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </button>
                <ul class="absolute hidden pt-1 text-gray-700 dropdown-menu">
                    @foreach ($this->listOfMonths() as $month)
                        <li class="">
                            <button class="block px-4 py-2 whitespace-no-wrap bg-white hover:bg-gray-400"
                                wire:click="month('{{ $month }}')">{{ $month }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>


    </div>
</div>
