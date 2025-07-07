<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">الأسئلة المرسلة</h2>

                @forelse($fatwas as $fatwa)
                    <div class="bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-4 mb-4 shadow-sm">
                        <p class="text-gray-800 dark:text-gray-100 mb-4">
                            <strong>السؤال:</strong> {{ $fatwa->question }}
                        </p>

                        <form method="POST" action="{{ route('admin.fatwas.assign', $fatwa) }}" class="flex flex-wrap items-center gap-3">
                            @csrf
                            <label for="sheikh_id_{{ $fatwa->id }}" class="text-sm text-gray-700 dark:text-gray-300">تعيين إلى:</label>
                            <select name="sheikh_id" id="sheikh_id_{{ $fatwa->id }}"
                                    class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                @foreach($sheikhs as $sheikh)
                                    <option value="{{ $sheikh->id }}">{{ $sheikh->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-paper-plane me-2"></i> تعيين
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100 p-4 rounded text-center">
                        لا توجد أسئلة جديدة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
