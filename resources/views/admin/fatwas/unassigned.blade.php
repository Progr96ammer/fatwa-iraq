<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 border-b pb-3 border-gray-300 dark:border-gray-600">
                    الفتاوى غير الموكلة
                </h2>

                {{-- إشعار النجاح --}}
                @if(session('success'))
                    <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 dark:bg-green-700 dark:text-white rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- عرض الفتاوى --}}
                @forelse($fatwas as $fatwa)
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <p class="mb-3 text-gray-800 dark:text-gray-100 leading-relaxed">
                            <span class="font-semibold">السؤال:</span> {{ $fatwa->question }}
                        </p>

                        <form method="POST" action="{{ route('admin.fatwas.assign', $fatwa) }}" class="flex flex-wrap items-center gap-3">
                            @csrf
                            <label for="sheikh_id_{{ $fatwa->id }}" class="sr-only">اختر شيخاً</label>
                            <select name="sheikh_id" id="sheikh_id_{{ $fatwa->id }}" class="form-select w-48 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                @foreach($sheikhs as $sheikh)
                                    <option value="{{ $sheikh->id }}">{{ $sheikh->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fas fa-user-plus me-2"></i> تعيين
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 mt-8">
                        لا توجد فتاوى غير موكلة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
