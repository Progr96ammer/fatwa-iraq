<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- العنوان --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">إدارة المستخدمين</h2>
                </div>

                {{-- جدول المستخدمين --}}
                <div class="p-6 overflow-x-auto">
                    <table id="myTable" class="min-w-[700px] w-full text-sm text-center text-gray-700 dark:text-gray-200">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <tr>
                                <th class="px-6 py-3">الاسم</th>
                                <th class="px-6 py-3">البريد الإلكتروني</th>
                                <th class="px-6 py-3">الدور الحالي</th>
                                <th class="px-6 py-3">تغيير الدور</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr 
                                    class="hover:bg-gray-50 dark:hover:bg-gray-800 transition cursor-pointer"
                                    onclick="window.location='{{ route('users.show', $user) }}'"
                                >
                                    <td class="px-6 py-3 font-medium text-blue-600 dark:text-blue-400">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-3">{{ $user->email }}</td>
                                    <td class="px-6 py-3">
                                        {{ $user->roles->pluck('name')->join(', ') ?: 'user' }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{-- منع تفعيل الانتقال عند النقر داخل الفورم --}}
                                        <form action="{{ route('users.update', $user) }}" method="POST"
                                            class="flex flex-col sm:flex-row items-center justify-center gap-3"
                                            onclick="event.stopPropagation();">
                                            @csrf
                                            @method('PUT')
                                            <select name="role"
                                                class="form-select w-full sm:w-auto dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded px-3 py-2 text-sm">
                                                <option value="">اختر دوراً</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="px-4 py-2 text-xs sm:text-sm bg-green-600 text-white rounded hover:bg-green-700 transition shadow-sm whitespace-nowrap">
                                                <i class="fas fa-check me-1"></i> تحديث
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                        لا يوجد مستخدمون حالياً.
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
