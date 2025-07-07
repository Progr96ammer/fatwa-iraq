<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">إرسال سؤال جديد</h2>

                <form method="POST" action="{{ route('fatwas.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="question" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            السؤال الشرعي <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="question"
                            name="question"
                            rows="5"
                            class="form-textarea w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                            required
                        >{{ old('question') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                            <i class="fas fa-paper-plane me-2"></i> إرسال السؤال
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
