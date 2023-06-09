<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Card (Recent Activity) -->
            <x-dashboard.recent-activity :todaysNotes="$todaysNotes" :yesterdaysNotes="$yesterdaysNotes" />

        </div>

    </div>
</x-app-layout>
