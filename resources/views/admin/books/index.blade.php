<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                {{-- العنوان --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">📚 المكتبة الإلكترونية</h2>
                    @role('admin')
                        <a href="{{ route('books.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow transition">
                            <i class="fas fa-plus-circle me-2"></i> إضافة كتاب
                        </a>
                    @endrole
                </div>

                {{-- جدول الكتب --}}
                <div class="p-6 overflow-x-auto">
                    <table id="myTable" class="min-w-[900px] w-full text-sm text-right text-gray-700 dark:text-gray-200 rtl">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <tr>
                                <th class="px-4 py-3">الغلاف</th>
                                <th class="px-4 py-3">العنوان</th>
                                <th class="px-4 py-3">الوصف</th>
                                <th class="px-4 py-3">تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($books as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition cursor-pointer"
                                    onclick="window.location='{{ route('books.show', $book) }}'">
                                    <td class="px-4 py-3">
                                        @if($book->cover)
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="غلاف"
                                                class="w-full h-auto max-h-48 object-contain rounded-md shadow-sm border border-gray-300 dark:border-gray-600">
                                        @else
                                            <span class="text-gray-400">لا يوجد</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-blue-600 dark:text-blue-400">
                                        {{ $book->title }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($book->description, 80) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $book->created_at->translatedFormat('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                        لا توجد كتب حالياً.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
