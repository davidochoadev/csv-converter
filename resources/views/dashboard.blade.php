<x-app-layout title="Dashboard ">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <!-- Tabella per visualizzare i dati caricati -->
            <livewire:feedback-user-list />
        </div>
    </div>
</x-app-layout>
