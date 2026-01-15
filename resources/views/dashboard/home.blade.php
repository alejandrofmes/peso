<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


 
    {{-- @include('dashboard.partials.employer-dash') --}}

    {{-- @include('dashboard.partials.jobseeker-application') --}}


   @include('dashboard.partials.job-dash')



</x-app-layout>
