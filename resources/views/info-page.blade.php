<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 text-start">
        <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div dir="rtl" class="text-start bg-white dark:bg-gray-800 p-6 rounded shadow mb-10 whitespace-pre-line">
            {!! nl2br(e($content)) !!}
        </div>

        @role('admin')
        <form method="POST" action="{{ route('info.update', $page) }}">
            @csrf
            <div class="mb-4 text-start">
                <label for="content" class="form-label fw-semibold">نص المقال</label>
                <textarea id="content" name="content" rows="10" class="text-start form-control shadow-sm p-3 rounded-3 border-0 bg-light text-start" dir="rtl" required>{{ old('content', $content) }}</textarea>
            </div>


            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                حفظ التعديلات
            </button>
        </form>
        @endrole
    </div>
</x-app-layout>
