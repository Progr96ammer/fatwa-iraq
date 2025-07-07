<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        تعديل بيانات المستخدم
                    </h2>
                </div>

                {{-- Form --}}
                <div class="p-6">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        {{-- الاسم --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">الاسم</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control dark:bg-gray-900 dark:text-white mt-1" required>
                        </div>

                        {{-- البريد الإلكتروني --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control dark:bg-gray-900 dark:text-white mt-1" required>
                        </div>

                        {{-- الدور --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">الدور</label>
                            <select name="role" class="form-select dark:bg-gray-900 dark:text-white mt-1" required>
                                <option value="">اختر دورًا</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- الأزرار --}}
                        <div class="flex gap-3 mt-6">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded shadow-sm transition">
                                <i class="fas fa-save me-1"></i> حفظ التعديلات
                            </button>

                            <a href="{{ route('users.show', $user) }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded shadow-sm transition">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
