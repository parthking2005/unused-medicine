<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Medicine Donation System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Making Medicine Accessible to All
                    </div>

                    <div class="mt-6 text-gray-500">
                        Our platform connects medicine donors with NGOs to help provide essential medications to those in need. Join us in making healthcare accessible to everyone.
                    </div>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Easy Donation Process</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Donate medicines in just a few clicks. Our streamlined process ensures your donations reach those who need them most.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Trusted NGO Partners</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                We work with verified NGOs to ensure your donations are handled professionally and reach the intended beneficiaries.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NGO Section -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Featured NGOs</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($ngos as $ngo)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold">{{ $ngo->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-2">{{ $ngo->description }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('ngo.show', $ngo->id) }}" class="text-indigo-600 hover:text-indigo-900">Learn More →</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Impact Section -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Our Impact</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                            <div>
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats->total_donations }}</div>
                                <div class="text-sm text-gray-600">Total Donations</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats->total_ngos }}</div>
                                <div class="text-sm text-gray-600">Partner NGOs</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats->total_beneficiaries }}</div>
                                <div class="text-sm text-gray-600">Beneficiaries Helped</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats->total_medicines }}</div>
                                <div class="text-sm text-gray-600">Medicines Donated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-8 mb-8">
                <div class="bg-indigo-700 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-white mb-4">Ready to Make a Difference?</h3>
                        <p class="text-indigo-100 mb-6">Join our community of donors and help make healthcare accessible to everyone.</p>
                        <div class="space-x-4">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Register Now
                            </a>
                            <a href="{{ route('about') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>