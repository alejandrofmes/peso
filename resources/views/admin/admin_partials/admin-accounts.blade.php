<x-admin-layout>

    <div class="container mx-auto py-8">

        {{-- GRID --}}
        <div class="grid grid-cols-4 sm:grid-cols-12 gap-4 p-3 sm:p-0">

            {{-- TITLE --}}
            <div class="col-span-4 sm:col-span-12">
                <h1 class="text-2xl font-bold">Admin Accounts (BALIWAG)</h1>
            </div>

            <div class="col-span-4 sm:col-span-12">



                @livewire('admin.account-management-admin.account-table')


            </div>

        </div>

    </div>
    </div>

    @livewire('admin.account-management-admin.edit-modal');

    @livewire('admin.account-management-admin.add-modal');

</x-admin-layout>
