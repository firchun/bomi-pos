    <aside class="w-20 bg-resto-purple flex flex-col items-center py-6 space-y-6 fixed top-0 left-0 h-full z-20">
        @php
            $shop = \App\Models\ShopProfile::first();
        @endphp
        <div class="p-2 bg-white/20 rounded-lg">
            <img src="{{ asset('storage/' . $shop->photo) }}" alt="Shop Photo" class="w-8 h-8 rounded-full object-cover">
        </div>
        <nav class="flex flex-col space-y-6 flex-grow items-center">
            <a href="{{ route('user.pos') }}" id="posViewButton" class="p-3 bg-white/30 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </a>
            <a href="#" id="tableManagementButton" class="p-3 rounded-lg hover:bg-white/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
            </a>
        </nav>
        <a href="{{ route('home') }}">
            <div class="p-3 rounded-lg hover:bg-white/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </div>
        </a>
    </aside>
