<x-app-layout>
    <div class="py-10 bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg mb-10">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center text-lg sm:text-xl font-bold">
                    مرحباً بك في موقع الفتاوى العراقية - مصدرك للفتاوى الشرعية والأخبار والكتب الاسلامية
                </div>
            </div>

            <!-- Sections Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12" dir="rtl">
                <!-- الفتاوى -->
                <a href="{{ route('fatwas.index') }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 hover:shadow-xl transition">
                    <div class="text-3xl mb-2">📜</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">الفتاوى</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        استعرض الفتاوى الشرعية المطروحة من قبل المستخدمين وإجابة العلماء.
                    </p>
                </a>

                <!-- الأخبار -->
                <a href="{{ route('news.index') }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 hover:shadow-xl transition">
                    <div class="text-3xl mb-2">📰</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">الأخبار</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        اطلع على آخر المستجدات والأخبار الشرعية والمجتمعية.
                    </p>
                </a>

                <!-- الكتب -->
                <a href="{{ route('books.index') }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 hover:shadow-xl transition">
                    <div class="text-3xl mb-2">📚</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">الكتب</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        تصفح المكتبة الإسلامية الغنية بالكتب المفيدة في شتى العلوم الشرعية.
                    </p>
                </a>

                <!-- الصوتيات -->
                <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 opacity-70 cursor-not-allowed">
                    <div class="absolute top-2 left-2 bg-yellow-400 text-xs text-black px-2 py-1 rounded font-semibold shadow">
                        🕒 يفتح قريبًا
                    </div>
                    <div class="text-3xl mb-2">🎧</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">الصوتيات</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        استمع إلى خطب ودروس صوتية لعلماء العراق قريبًا بإذن الله.
                    </p>
                </div>

                <!-- الاستشارات -->
                <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 opacity-70 cursor-not-allowed">
                    <div class="absolute top-2 left-2 bg-yellow-400 text-xs text-black px-2 py-1 rounded font-semibold shadow">
                        🕒 يفتح قريبًا
                    </div>
                    <div class="text-3xl mb-2">💬</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">الاستشارات</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        استشارات أسرية وشرعية مقدمة من نخبة العلماء قريبًا.
                    </p>
                </div>

                <!-- البث المباشر -->
                <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 opacity-70 cursor-not-allowed">
                    <div class="absolute top-2 left-2 bg-yellow-400 text-xs text-black px-2 py-1 rounded font-semibold shadow">
                        🕒 يفتح قريبًا
                    </div>
                    <div class="text-3xl mb-2">📺</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">البث المباشر</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        بث مباشر للدروس والمحاضرات الشرعية سيتم إطلاقه قريبًا.
                    </p>
                </div>
            </div>

                {{-- المحتوى --}}
                <div class="relative z-10 p-6 bg-white/80 dark:bg-gray-800/80 rounded-xl shadow">
                        <div class="absolute inset-0" style="background-image: url('{{ asset('images/background-pattern.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2;"></div>

                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">📜 آخر الفتاوى</h2>

                    <div id="fatwasCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($latestFatwas as $index => $fatwa)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <a href="{{ route('fatwas.show', $fatwa->id) }}"
                                    class="block bg-white dark:bg-gray-700 rounded shadow-md hover:shadow-lg transition overflow-hidden">
                                        <div class="p-4">
                                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-1">
                                                {{ Str::limit($fatwa->question, 50, '...') }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ Str::limit($fatwa->answer, 80, '...') }}
                                            </p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $fatwa->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#fatwasCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#fatwasCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="mt-5 text-center position-relative z-3">
                        <a href="{{ route('fatwas.index') }}"
                        class="inline-block px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-100 hover:bg-blue-200 dark:text-blue-300 dark:bg-blue-900 dark:hover:bg-blue-800 rounded transition">
                            عرض كل الفتاوى
                        </a>
                    </div>
                </div>
            </section>
            <!-- آخر الكتب -->
            <section class="mt-16 mb-16" dir="rtl">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">📚 آخر الكتب</h2>

                <div id="booksCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($latestBooks as $index => $book)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">                                
                                <a href="{{ route('books.show', $book->id) }}"
                                   class="block bg-white dark:bg-gray-700 rounded shadow-md hover:shadow-lg transition overflow-hidden">
                                   <img src="{{ asset('storage/app/public/' . $book->cover) }}"
                                      alt="{{ $book->title }}"
                                      class="w-full h-48 object-cover rounded-t">
                                   <div class="p-4">
                                      <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-1">
                                         {{ Str::limit($book->title, 50, '...') }}
                                      </h3>
                                      <p class="text-sm text-gray-600 dark:text-gray-300">
                                         {{ Str::limit($book->description, 80, '...') }}
                                      </p>
                                      <span class="text-xs text-gray-500 dark:text-gray-400">
                                         {{ $book->created_at->diffForHumans() }}
                                      </span>
                                   </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#booksCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#booksCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="mt-5 text-center">
                    <a href="{{ route('books.index') }}"
                       class="inline-block px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-100 hover:bg-blue-200 dark:text-blue-300 dark:bg-blue-900 dark:hover:bg-blue-800 rounded transition">
                        عرض كل الكتب
                    </a>
                </div>
            </section>

            <!-- آخر الأخبار -->
            <section class="mt-16" dir="rtl">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">📰 آخر الأخبار</h2>

                <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($latestNews as $index => $news)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <a href="{{ route('news.show', $news->id) }}"
                                   class="block bg-white dark:bg-gray-700 rounded shadow-md hover:shadow-lg transition overflow-hidden">
                                   <img src="{{ asset('storage/app/public/' . $news->image) }}"
                                      alt="{{ $news->title }}"
                                      class="w-full h-48 object-cover rounded-t">
                                   <div class="p-4">
                                      <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-1">
                                         {{ Str::limit($news->title, 50, '...') }}
                                      </h3>
                                      <p class="text-sm text-gray-600 dark:text-gray-300">
                                         {{ Str::limit($news->content, 80, '...') }}
                                      </p>
                                      <span class="text-xs text-gray-500 dark:text-gray-400">
                                         {{ $news->created_at->diffForHumans() }}
                                      </span>
                                   </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="mt-5 text-center">
                    <a href="{{ route('news.index') }}"
                       class="inline-block px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-100 hover:bg-blue-200 dark:text-blue-300 dark:bg-blue-900 dark:hover:bg-blue-800 rounded transition">
                        عرض كل الأخبار
                    </a>
                </div>
            </section>

            <!-- أحدث المقالات -->
            <section class="mt-16" dir="rtl">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">✍️ أحدث المقالات</h2>

                <div id="articlesCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($latestArticles as $index => $article)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <a href="{{ route('articles.show', $article->id) }}"
                                class="block bg-white dark:bg-gray-700 rounded shadow-md hover:shadow-lg transition overflow-hidden">
                                <img src="{{ asset('storage/app/public/' . $article->image) }}"
                                    alt="{{ $article->title }}"
                                    class="w-full h-48 object-cover rounded-t">
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-1">
                                        {{ Str::limit($article->title, 50, '...') }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ Str::limit(strip_tags($article->content), 80, '...') }}
                                    </p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $article->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#articlesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#articlesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="mt-5 text-center">
                    <a href="{{ route('articles.index') }}"
                    class="inline-block px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-100 hover:bg-blue-200 dark:text-blue-300 dark:bg-blue-900 dark:hover:bg-blue-800 rounded transition">
                        عرض كل المقالات
                    </a>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-300 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600 dark:text-gray-400">
            <div>© {{ now()->year }} موقع الفتاوى العراقية. جميع الحقوق محفوظة.</div>
            <div class="mt-2 sm:mt-0 space-x-4">
                <a href="#" class="hover:underline">من نحن</a>
                <a href="#" class="hover:underline">اتصل بنا</a>
                <a href="#" class="hover:underline">سياسة الخصوصية</a>
            </div>
        </div>
    </footer>
</x-app-layout>
