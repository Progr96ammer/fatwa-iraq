<nav x-data="{ open: false, openNotif: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Right -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- Hamburger -->
                <div class="sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                        إنشاء حساب
                    </a>
                @endguest

                @auth
                    <!-- User -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 transition">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    البروفايل
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        تسجيل الخروج
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <!-- Notifications -->
                    <div class="relative" x-data="{ openNotif: false }" @click.away="openNotif = false">
                        <button @click="openNotif = !openNotif" class="relative text-gray-700 dark:text-gray-300 hover:text-blue-600 focus:outline-none">
                            🔔
                            <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs rounded-full px-1">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </button>
                        <div x-show="openNotif" x-transition class="absolute mt-2 w-64 bg-white dark:bg-gray-800 shadow-lg rounded-md z-50" style="display: none;">
                            <ul class="py-2 max-h-60 overflow-y-auto text-sm">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700" href="{{ $notification->data['url'] }}">
                                            {{ $notification->data['message'] }}
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="block px-4 py-2 text-gray-500">لا إشعارات جديدة</span></li>
                                @endforelse
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <li>
                                        <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                            @csrf
                                            <button class="w-full text-center text-blue-600 hover:underline py-2" type="submit">
                                                تحديد الكل كمقروء
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endauth
                <!-- Search (Desktop with Autocomplete) -->
                <form class="hidden sm:flex items-center relative w-64" onkeypress="return event.key !== 'Enter';">
                    <input type="text" id="search" name="q" class="form-control px-2 py-1 rounded w-full" placeholder="ابحث..." autocomplete="off">
                    <ul id="autocomplete-results"
                        class="absolute top-full left-0 z-50 bg-white dark:bg-gray-700 w-full shadow rounded text-sm overflow-hidden border border-gray-300 dark:border-gray-600 hidden max-h-60 overflow-y-auto">
                    </ul>
                </form>
            </div>
            <!-- Left -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('info.show', 'about') }}">
                        من نحن
                    </x-nav-link>

                    <x-nav-link href="{{ route('info.show', 'vision') }}">
                        الرؤية
                    </x-nav-link>

                    <x-nav-link href="{{ route('info.show', 'goals') }}">
                        الأهداف
                    </x-nav-link>

                    <x-nav-link href="{{ route('info.show', 'summary') }}">
                        نبذة مختصرة
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            لوحة التحكم
                        </x-nav-link>
                    @endauth

                </div>
                <div class="shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <!-- Search (Mobile with Autocomplete) -->
        <div class="px-4 py-2 relative">
            <form class="relative w-full" onkeypress="return event.key !== 'Enter';">
                <input type="text" id="search-mobile" name="q" placeholder="ابحث عن فتوى أو خبر أو كتاب..." autocomplete="off" class="form-control w-full px-2 py-1 rounded">
                <ul id="autocomplete-results-mobile" class="absolute top-full left-0 z-50 bg-white dark:bg-gray-700 w-full shadow rounded text-sm overflow-hidden border border-gray-300 dark:border-gray-600 hidden max-h-60 overflow-y-auto"></ul>
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('fatwas.index')" :active="request()->routeIs('fatwas.*')">
                الفتاوى
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                الأخبار
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">
                الكتب
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            لوحة التحكم
            </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        البروفايل
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            تسجيل الخروج
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 border-t border-gray-200 dark:border-gray-600">
                <x-responsive-nav-link :href="route('login')">
                    تسجيل الدخول
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    إنشاء حساب
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>

<script>
function setupAutocomplete(inputId, resultBoxId) {
    const input = document.getElementById(inputId);
    const results = document.getElementById(resultBoxId);

    input.addEventListener("input", function () {
        const query = this.value;

        if (query.length < 2) {
            results.innerHTML = '';
            results.classList.add("hidden");
            return;
        }
        const typeToPath = {
            news: "news",
            book: "books",
            fatwa: "fatwas"
        };

        fetch(`/autocomplete?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                results.innerHTML = '';
                if (data.length > 0) {
                    const typeToPath = {
                        news: { path: "news", label: "خبر" },
                        book: { path: "books", label: "كتاب" },
                        fatwa: { path: "fatwas", label: "فتوى" }
                    };

                    data.forEach(item => {
                        const li = document.createElement("li");
                        li.className = "px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer";
                        const type = typeToPath[item.type];
                        li.textContent = `${item.title} (${type.label})`;
                        li.addEventListener("click", () => {
                            window.location.href = `/${type.path}/${item.id}`;
                        });
                        results.appendChild(li);
                    });
                    results.classList.remove("hidden");
                } else {
                    results.classList.add("hidden");
                }
            });
    });

    document.addEventListener("click", function (e) {
        if (!input.contains(e.target) && !results.contains(e.target)) {
            results.innerHTML = '';
            results.classList.add("hidden");
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupAutocomplete("search", "autocomplete-results");
    setupAutocomplete("search-mobile", "autocomplete-results-mobile");
});
</script>
