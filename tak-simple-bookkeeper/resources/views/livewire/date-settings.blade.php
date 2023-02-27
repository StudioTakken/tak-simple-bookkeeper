<div class="flex gap-3 items-left">
    <div class="flex flex-row">

        <input class="py-0 border-gray-400" type="date" wire:model="startDate" id="startDate" name="startDate">
        <input class="py-0 border-gray-400" type="date" wire:model="stopDate" id="stopDate" name="stopDate">

        <div class="flex flex-col p-0 m-0">
        </div>
        <div class="flex flex-col">
        </div>

        <div class="flex flex-col mx-2 my-1 ml-4">
            <button class="btn btn-gray-500 btn-small" wire:click="lastYear">Vorig jaar</button>
        </div>
        <div class="flex flex-col mx-2 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="thisYear">Dit jaar</button>
        </div>
        <div class="flex flex-col mx-2 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="thisQuarter">Dit kwartaal</button>
        </div>
        <div class="flex flex-col mx-2 my-1">
            <button class="btn btn-gray-500 btn-small" wire:click="lastQuarter">Vorig kwartaal</button>
        </div>
    </div>
</div>
