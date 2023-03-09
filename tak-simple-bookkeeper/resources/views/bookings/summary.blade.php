<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">



                {{-- {{ ucfirst(Session::get('viewscope')) }} --}}
                Summary


            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="py-6">


        <div class="grid grid-cols-4 gap-4">
            <div>
                Debit


                <div class="grid grid-cols-4 gap-4">
                    <div>
                        item
                    </div>
                    <div>
                        123,-
                    </div>
                </div>


            </div>
            <div>
                Credit

                <div class="grid grid-cols-4 gap-4">
                    <div>
                        item
                    </div>
                    <div>
                        123,-
                    </div>
                </div>



            </div>
        </div>

    </div>
</x-app-layout>
