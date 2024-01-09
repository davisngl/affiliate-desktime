<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <h1 class="text-xl font-bold text-gray-900">Your own referral links</h1>
                        <p class="text-xs text-gray-500">Share any of the 3 links below to your friends and
                            they will be registered as referred by you. You can click on them to see more about them.</p>
                    </section>

                    <section>
                        <canvas id="affiliate"></canvas>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        new Chart(window.affiliate, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
    </script>
</x-app-layout>
