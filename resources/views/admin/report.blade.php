<x-dashboard>
    <x-slot:role> Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => ['manage-users','complaint','token-regeneration','generate-report']])
    </x-slot:links>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Report Summary</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-lg font-semibold">Total Users</h2>
                <p class="text-2xl">{{ $totalUsers }}</p>
            </div>

            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-lg font-semibold">Token Regenerations</h2>
                <p class="text-2xl">{{ $totalTokenRegenerations }}</p>
            </div>

            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-lg font-semibold">Complaints</h2>
                <p class="text-2xl">{{ $totalComplaints }}</p>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">Recent Users</h2>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="py-2 px-4">Name</th>
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4">{{ $user->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Token Regenerations -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">Recent Token Regenerations</h2>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Requested At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokenRegenerations as $request)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $request->voter->email }}</td>
                            <td class="py-2 px-4">{{ $request->status }}</td>
                            <td class="py-2 px-4">{{ $request->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">No token requests found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">Recent Complaints</h2>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="py-2 px-4">Email</th>
                            <th class="py-2 px-4">Description</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $complaint->email }}</td>
                            <td class="py-2 px-4">{{ \Illuminate\Support\Str::limit($complaint->description, 50) }}</td>
                            <td class="py-2 px-4">{{ $complaint->status }}</td>
                            <td class="py-2 px-4">{{ $complaint->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">No complaints found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-end mb-6">
            <a href="/admin/reports/download"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                Download PDF
            </a>
        </div>
    </div>
</x-dashboard>