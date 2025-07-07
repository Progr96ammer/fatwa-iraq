<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">إضافة كتاب جديد</h2>

                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">عنوان الكتاب <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" class="form-input w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="description" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">الوصف</label>
                        <textarea id="description" name="description" rows="4" class="form-textarea w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label for="cover" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">غلاف الكتاب</label>
                        <input type="file" id="cover" name="cover" class="form-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>

                    <div>
                        <label for="file" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">ملف الكتاب (PDF) <span class="text-red-500">*</span></label>
                        <input type="file" id="file" name="file" class="form-input w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                            <i class="fas fa-plus-circle me-2"></i> إضافة الكتاب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
