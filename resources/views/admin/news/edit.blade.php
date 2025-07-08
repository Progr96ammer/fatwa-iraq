<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">تعديل الخبر</h2>

                <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">العنوان</label>
                        <input type="text" id="title" name="title" class="form-input w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required value="{{ old('title', $news->title) }}">
                    </div>

                    <div>
                        <label for="body" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">المحتوى</label>
                        <textarea id="body" name="body" rows="6" class="form-textarea w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required>{{ old('body', $news->body) }}</textarea>
                    </div>

                    <div>
                        <label for="image" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">الصورة</label>
                        <input type="file" id="image" name="image" class="form-input w-full dark:bg-gray-900 dark:text-white">
                        @if ($news->image)
                            <img src="{{ asset('storage/app/public/' . $news->image) }}" alt="صورة الخبر" class="mt-2 rounded shadow-sm" style="max-height: 150px;">
                        @endif
                    </div>

                    <div class="text-end">
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                            <i class="fas fa-save me-2"></i> تحديث الخبر
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
