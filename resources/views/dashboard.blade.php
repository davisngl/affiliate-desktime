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
                    @if(session()->has('successful_affiliate_registration'))
                        <div class="rounded-md bg-green-50 p-4 mb-5">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"
                                         aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session()->get('successful_affiliate_registration') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <div class="flex flex-col">
                            <h1 class="text-xl font-bold text-gray-900">Your own referral links</h1>
                            <p class="text-xs text-gray-500">Share any of the 3 links below to your friends and
                                they will be registered as referred by you. You can click on them to see more about them.</p>
                        </div>

                        <div class="mt-5 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach(auth()->user()->affiliateCodes as $affiliate)
                                    <li>
                                        <a
                                            class="text-blue-700 hover:underline"
                                            href="{{ route('affiliate-code-statistics.show', ['affiliate' => $affiliate->code]) }}"
                                        >
                                            {{ $affiliate->url() }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
