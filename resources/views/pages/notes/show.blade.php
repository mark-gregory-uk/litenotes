<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <!-- Cards -->
        <div class="">
            <!-- Card (Customers)  -->
            <x-notes.show-card :note="$note"/>
        </div>

    </div>
</x-app-layout>
