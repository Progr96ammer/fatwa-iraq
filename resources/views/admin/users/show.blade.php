<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        معلومات المستخدم: {{ $user->name }}
                    </h2>
                    <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                        ← الرجوع إلى القائمة
                    </a>
                </div>

                {{-- User Details --}}
                <div class="p-6 text-gray-700 dark:text-gray-100 space-y-4">
                    <div class="flex items-center gap-2">
                        <strong class="w-32">الاسم:</strong>
                        <span>{{ $user->name }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <strong class="w-32">البريد الإلكتروني:</strong>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <strong class="w-32">الدور:</strong>
                        <span class="inline-block bg-info text-dark px-3 py-1 rounded text-sm fw-bold">
                            {{ $user->roles->pluck('name')->join(', ') ?: 'user' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <strong class="w-32">تاريخ التسجيل:</strong>
                        <span>{{ $user->created_at->translatedFormat('Y-m-d H:i') }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 pb-6 pt-4 flex gap-3">
                    {{-- تعديل --}}
                    <a href="{{ route('users.edit', $user) }}"
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded shadow-sm transition">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>

                    {{-- حذف --}}
                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded shadow-sm transition">
                            <i class="fas fa-trash me-1"></i> حذف
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
