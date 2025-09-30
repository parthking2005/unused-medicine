<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- NGO Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $ngo->name }}</h3>
                            <p class="text-gray-600">{{ $ngo->address }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Manager Since</div>
                            <div class="font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Today's Donations</div>
                        <div class="text-2xl font-semibold">{{ $stats->donations_today }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Active Pickupmen</div>
                        <div class="text-2xl font-semibold">{{ $stats->active_pickupmen }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Medicine Stock</div>
                        <div class="text-2xl font-semibold">{{ $stats->total_stock }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Pending Verifications</div>
                        <div class="text-2xl font-semibold">{{ $stats->pending_verifications }}</div>
                    </div>
                </div>
            </div>

            <!-- Pending Donations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Pending Donations</h3>
                        <a href="{{ route('manager.donations') }}" class="text-indigo-600 hover:text-indigo-900">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donator</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pickup Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pending_donations as $donation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $donation->donator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $donation->pickup_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('manager.donations.assign', $donation->id) }}" class="text-indigo-600 hover:text-indigo-900">Assign</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Medicine Stock -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Low Stock Medicines</h3>
                        <a href="{{ route('manager.stock') }}" class="text-indigo-600 hover:text-indigo-900">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($low_stock_medicines as $medicine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $medicine->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $medicine->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $medicine->stock_quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Low Stock
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('manager.pickupmen.create') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100">
                            <div class="text-blue-700 font-semibold">Add Pickupman</div>
                            <div class="text-sm text-blue-600 mt-1">Register a new pickupman</div>
                        </a>
                        <a href="{{ route('manager.verifiers.create') }}" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100">
                            <div class="text-green-700 font-semibold">Add Verifier</div>
                            <div class="text-sm text-green-600 mt-1">Register a new verifier</div>
                        </a>
                        <a href="{{ route('manager.stock.update') }}" class="block p-6 bg-yellow-50 rounded-lg hover:bg-yellow-100">
                            <div class="text-yellow-700 font-semibold">Update Stock</div>
                            <div class="text-sm text-yellow-600 mt-1">Update medicine stock levels</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
