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
                        <h1 class="text-xl font-bold text-gray-900">Performance of your own link</h1>
                        <p class="text-xs text-gray-500">{{ $affiliateUrl }} <span class="font-semibold">({{ $totalClicks }} total clicks)</span></p>
                    </section>

                    <div class="flex flex-col space-y-5 md:flex-row md:justify-around md:space-x-5 mt-5">
                        <div class="md:mt-5 w-full md:w-1/3">
                            <ul class="border border-gray-500 bg-gray-100 p-5 rounded-md divide-y divide-gray-200">
                                <h2 class="text-xl font-semibold my-2">Latest 15 clicks</h2>

                                @forelse($clickEvents as $click)
                                    <li class="pb-1 flex justify-between">
                                        <span>{{ $click->clicked_at }}</span>
                                        <span class="text-gray-500 text-xs">({{ $click->clicked_at->diffForHumans() }})</span>
                                    </li>
                                @empty
                                    There are no clicks on your link... yet
                                @endforelse
                            </ul>
                        </div>

                        <div class="md:mt-5 w-full md:w-2/3">
                            <canvas id="affiliate"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
        new Chart(window.affiliate, {
            type: 'bar',
            data: {
                labels: @js($dataset->labels()),
                datasets: [{
                    label: 'Clicks per day',
                    data: @js($dataset->dataset()),
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
