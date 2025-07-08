<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-right">
                    {{ isset($article) ? 'تعديل المقالة' : 'إضافة مقالة جديدة' }}
                </h2>

                <form method="POST" 
                      action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}" 
                      enctype="multipart/form-data" 
                      class="space-y-6 text-right">
                    
                    @csrf
                    @if(isset($article))
                        @method('PUT')
                    @endif

                    {{-- العنوان --}}
                    <div>
                        <label for="title" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            العنوان <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                               class="form-input w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-right"
                               value="{{ old('title', $article->title ?? '') }}"
                               required>
                    </div>

                    {{-- المحتوى --}}
                    <div>
                        <label for="content" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            المحتوى <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" name="content" rows="6"
                                  class="form-textarea w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-right"
                                  required>{{ old('content', $article->content ?? '') }}</textarea>
                    </div>

                    {{-- الصورة --}}
                    <div>
                        <label for="image" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            الصورة
                        </label>
                        <input type="file" id="image" name="image"
                               class="form-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white
                               file:ml-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold
                               file:bg-blue-600 file:text-white hover:file:bg-blue-700 text-right">

                        @if(isset($article) && $article->image)
                            <div class="mt-4">
                                <img src="{{ asset('storage/app/public/' . $article->image) }}" class="w-32 rounded shadow">
                            </div>
                        @endif
                    </div>

                    {{-- زر الإرسال --}}
                    <div class="text-left">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                            <i class="fas fa-paper-plane ms-2"></i>
                            {{ isset($article) ? 'تحديث المقالة' : 'نشر المقالة' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
