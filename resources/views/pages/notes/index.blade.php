<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <!-- Cards -->
        <div class="grid grid-cols-4 gap-4">
            <!-- Card (Customers)  -->
            <x-notes.index-card :notes="$notes"/>
        </div>

    </div>
</x-app-layout>
