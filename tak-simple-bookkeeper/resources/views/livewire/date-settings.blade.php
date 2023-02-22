<div>

    {{-- add a livewire datapicker  --}}
    <div class="flex flex-col">
        <div class="flex flex-row">
            <div class="flex flex-col">
                <label for="startDate">Start</label>
                <input type="date" wire:model="startDate" id="startDate" name="startDate">
            </div>
            <div class="flex flex-col">
                <label for="stopDate">Stop </label>
                <input type="date" wire:model="stopDate" id="stopDate" name="stopDate">
            </div>
            <div class="flex flex-col m-5">
                <button class="btn btn-blue btn-small" wire:click="thisYear">Dit jaar</button>
            </div>
            <div class="flex flex-col m-5">
                <button class="btn btn-blue btn-small" wire:click="thisQuarter">Dit kwartaal</button>
            </div>
            <div class="flex flex-col m-5">
                <button class="btn btn-blue btn-small" wire:click="lastQuarter">Vorig kwartaal</button>
            </div>


        </div>


    </div>
