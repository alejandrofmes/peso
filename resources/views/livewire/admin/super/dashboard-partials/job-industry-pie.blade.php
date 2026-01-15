<div class="bg-white shadow rounded-lg p-6 h-full w-full">
    <h1 class="text-2xl font-bold">Top Job Industries</h1>
    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
    <div class="flex h-full items-end">
        <livewire:livewire-pie-chart {{-- key="{{ $columnChartModel->reactiveKey() }}" --}} :pie-chart-model="$pieChartModel">
    </div>
</div>
