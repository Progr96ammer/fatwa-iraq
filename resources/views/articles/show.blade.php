<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6" dir="rtl">

                    {{-- عنوان المقال --}}
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $article->title }}
                    </h1>

                    {{-- نص المقال --}}
                    <p class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed mb-6">
                        {{ $article->body }}
                    </p>

                    {{-- الكاتب وتاريخ النشر --}}
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        بقلم: {{ $article->user->name ?? 'مجهول' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        نُشر بتاريخ: {{ $article->created_at->translatedFormat('d M Y') }}
                    </p>

                    {{-- صورة المقال إن وجدت --}}
                    @if($article->image)
                        <div class="mt-6">
                            <img src="{{ asset('storage/' . $article->image) }}"
                                 alt="صورة المقال"
                                 class="w-full max-h-96 object-cover rounded-md border border-gray-300 dark:border-gray-600">
                        </div>
                    @endif

                    {{-- أزرار التحكم للمدير فقط --}}
                    @role('admin')
                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('articles.edit', $article) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                ✏️ تعديل
                            </a>

                            <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    🗑️ حذف
                                </button>
                            </form>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
