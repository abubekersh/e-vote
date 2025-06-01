<x-dashboard>
    <x-slot:role>{{$user->role}}</x-slot:role>
    <nav class="dashboard text-white text-4xl px-4 py-10">
        <ul class="flex flex-col gap-3 text-center  w-full">
            <a href="/">
                <li>Home</li>
            </a>
            <a href="/admin/manage-users">
                <li>Manage Users</li>
            </a>
            <a href="/admin/compliants">
                <li>Compliants</li>
            </a><a href="/logs">
                <li>System Logs</li>
            </a><a href="/admin/token">
                <li>Token Generation</li>
            </a>
            <a href="/admin/report">
                <li>Generate Report</li>
            </a>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button>
                    <li>logout</li>
                </button>
            </form>
        </ul>
    </nav>
</x-dashboard>