<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">

                @role('admin')
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 border-b pb-3">
                        <i class="fas fa-edit text-blue-500 me-2"></i> تعديل بيانات الكتاب
                    </h2>

                    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" class="grid gap-6">
                        @csrf
                        @method('PUT')

                        {{-- العنوان --}}
                        <div>
                            <label for="title" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">العنوان <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}"
                                class="form-input w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        {{-- الوصف --}}
                        <div>
                            <label for="description" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">الوصف</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-textarea w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('description', $book->description) }}</textarea>
                        </div>

                        {{-- غلاف الكتاب --}}
                        <div>
                            <label for="cover" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">غلاف الكتاب</label>
                            <input type="file" id="cover" name="cover" accept="image/*"
                                class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md file:bg-blue-600 file:text-white file:font-medium file:px-4 file:py-2 file:rounded file:border-0 hover:file:bg-blue-700">

                            @if($book->cover)
                                <img src="{{ asset('storage/app/public/' . $book->cover) }}" alt="غلاف سابق"
                                    class="mt-4 rounded shadow max-w-xs">
                            @endif
                        </div>

                        {{-- ملف الكتاب --}}
                        <div>
                            <label for="file" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">ملف الكتاب (PDF)</label>
                            <input type="file" id="file" name="file" accept="application/pdf"
                                class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md file:bg-green-600 file:text-white file:font-medium file:px-4 file:py-2 file:rounded file:border-0 hover:file:bg-green-700">

                            <a href="{{ asset('storage/app/public/' . $book->file) }}" target="_blank"
                                class="inline-flex items-center mt-3 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                <i class="fas fa-file-pdf me-2"></i> عرض الملف الحالي
                            </a>
                        </div>

                        {{-- زر الحفظ --}}
                        <div class="text-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fas fa-save me-2"></i> تحديث الكتاب
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 p-4 rounded">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ليس لديك صلاحية لتعديل هذا الكتاب.
                    </div>
                @endrole

            </div>
        </div>
    </div>
</x-app-layout>
