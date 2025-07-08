<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                {{-- العنوان وزر الإضافة للمدير فقط --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">إدارة الأخبار</h2>
                    @role('admin')
                        <a href="{{ route('news.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded hover:bg-green-700 transition">
                            <i class="fas fa-plus-circle me-2"></i> إضافة خبر جديد
                        </a>
                    @endrole
                </div>

                {{-- عرض الأخبار --}}
                @forelse($news as $item)
                    <div class="border rounded-lg mb-4 bg-gray-50 dark:bg-gray-900 shadow overflow-hidden">

                        {{-- رابط لتفاصيل الخبر --}}
                        <a href="{{ route('news.show', $item) }}" class="block p-4 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $item->title }}</h3>

                            @if($item->image)
                                <img src="{{ asset('storage/app/public/' . $item->image) }}" alt="صورة الخبر"
                                     class="rounded mb-3 max-h-48 w-full object-cover">
                            @endif

                            <p class="text-gray-600 dark:text-gray-300">{{ Str::limit($item->body, 100) }}</p>
                        </a>

                        {{-- أزرار التعديل والحذف (للمدير فقط) --}}
                        @role('admin')
                            <div class="px-4 py-2 border-t dark:border-gray-700 flex gap-3 bg-gray-100 dark:bg-gray-800">
                                <a href="{{ route('news.edit', $item) }}"
                                   class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                                    <i class="fas fa-edit me-1"></i> تعديل
                                </a>

                                <form action="{{ route('news.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition">
                                        <i class="fas fa-trash me-1"></i> حذف
                                    </button>
                                </form>
                            </div>
                        @endrole
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400">لا توجد أخبار حالياً.</div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
