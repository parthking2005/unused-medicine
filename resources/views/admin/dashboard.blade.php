<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total NGOs</div>
                        <div class="text-2xl font-semibold">{{ $stats->total_ngos }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Active Managers</div>
                        <div class="text-2xl font-semibold">{{ $stats->active_managers }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Donations</div>
                        <div class="text-2xl font-semibold">{{ $stats->total_donations }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Registered Donators</div>
                        <div class="text-2xl font-semibold">{{ $stats->total_donators }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent NGOs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent NGOs</h3>
                        <a href="{{ route('admin.ngos') }}" class="text-indigo-600 hover:text-indigo-900">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recent_ngos as $ngo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ngo->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ngo->manager->name ?? 'No Manager' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $ngo->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ngo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ngo->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.ngos.edit', $ngo->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Messages</h3>
                        <a href="{{ route('admin.messages') }}" class="text-indigo-600 hover:text-indigo-900">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recent_messages as $message)
                        <div class="border-l-4 border-indigo-400 bg-indigo-50 p-4">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-indigo-800">{{ $message->name }}</div>
                                <div class="text-sm text-indigo-600">{{ $message->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="mt-2 text-sm text-indigo-700">{{ $message->message }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.ngos.create') }}" class="block p-6 bg-indigo-50 rounded-lg hover:bg-indigo-100">
                            <div class="text-indigo-700 font-semibold">Add New NGO</div>
                            <div class="text-sm text-indigo-600 mt-1">Register a new NGO in the system</div>
                        </a>
                        <a href="{{ route('admin.managers.create') }}" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100">
                            <div class="text-green-700 font-semibold">Add New Manager</div>
                            <div class="text-sm text-green-600 mt-1">Create a new NGO manager account</div>
                        </a>
                        <a href="{{ route('admin.medicines.create') }}" class="block p-6 bg-purple-50 rounded-lg hover:bg-purple-100">
                            <div class="text-purple-700 font-semibold">Add Medicine Category</div>
                            <div class="text-sm text-purple-600 mt-1">Create a new medicine category</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>