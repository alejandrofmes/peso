<div class="bg-white shadow rounded-lg p-6 h-full w-full ">
    <h1 class="text-2xl font-bold">Most Preferred Job Tags</h1>
    <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
    <div class="flex flex-col h-[400px] lg:h-full items-end">
        <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
    </div>
</div>
