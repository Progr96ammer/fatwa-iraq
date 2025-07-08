<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-8 text-center text-gray-900 dark:text-gray-100">

                    {{-- غلاف الكتاب --}}
                    @if($book->cover)
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('storage/app/public/' . $book->cover) }}"
                                 alt="غلاف الكتاب"
                                 class="w-60 h-auto rounded-lg shadow-lg">
                        </div>
                    @endif

                    {{-- عنوان الكتاب --}}
                    <h1 class="text-3xl font-extrabold text-blue-700 dark:text-blue-400 mb-4">
                        {{ $book->title }}
                    </h1>

                    {{-- وصف الكتاب --}}
                    <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 mb-6">
                        {{ $book->description }}
                    </p>

                    {{-- تاريخ الإضافة --}}
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                        <i class="fas fa-calendar-alt me-1"></i>
                        تاريخ الإضافة: {{ optional($book->created_at)->translatedFormat('d M Y') ?? 'غير متوفر' }}
                    </p>

                    {{-- زر التحميل --}}
                    @if($book->file)
                        <a href="{{ asset('storage/app/public/' . $book->file) }}"
                           class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold text-sm rounded-md shadow hover:bg-green-700 transition"
                           download>
                            <i class="fas fa-download me-2"></i> تحميل الكتاب
                        </a>
                    @endif

                    {{-- أزرار التعديل والحذف للمدير --}}
                    @role('admin')
                        <div class="mt-8 flex justify-center gap-4">
                            <a href="{{ route('books.edit', $book->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600 transition">
                                <i class="fas fa-edit me-2"></i> تعديل
                            </a>

                            <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الكتاب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
                                    <i class="fas fa-trash me-2"></i> حذف
                                </button>
                            </form>
                        </div>
                    @endrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
