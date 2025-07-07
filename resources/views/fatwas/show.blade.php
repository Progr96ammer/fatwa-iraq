<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                {{-- عنوان الصفحة --}}
                <div class="mb-6 border-b border-gray-300 dark:border-gray-700 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">تفاصيل الفتوى</h2>
                </div>

                {{-- بيانات الفتوى --}}
                <div class="space-y-6 text-gray-700 dark:text-gray-100">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">رقم الفتوى:</label>
                        <p class="mt-1">{{ $fatwa->id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">السؤال:</label>
                        <p class="mt-1">{{ $fatwa->question }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">السائل:</label>
                        <p class="mt-1">{{ $fatwa->user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">تاريخ السؤال:</label>
                        <p class="mt-1">{{ $fatwa->created_at->translatedFormat('Y-m-d H:i') }}</p>
                    </div>
                </div>

                {{-- عرض الإجابة إن وجدت --}}
                @if($fatwa->answer)
                    <div class="mt-6 bg-green-100 dark:bg-green-700/20 border border-green-300 dark:border-green-600 rounded p-4">
                        <h3 class="text-lg font-semibold text-green-800 dark:text-green-300 mb-2">الإجابة:</h3>
                        <p class="text-gray-800 dark:text-gray-100">{{ $fatwa->answer }}</p>
                    </div>
                @endif
                @if($fatwa->categories->isNotEmpty())
                    <div class="mt-6 text-sm text-gray-700 dark:text-gray-200">
                        <label class="block font-semibold mb-2">التصنيفات:</label>
                        <div class="flex flex-wrap items-center gap-2 rtl space-x-2 rtl:space-x-reverse">
                            @foreach($fatwa->categories as $category)
                                <div class="flex items-center text-xs">
                                    <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-100 rounded-full border border-indigo-300 dark:border-indigo-700 shadow-sm">
                                        {{ $category->name }}
                                    </span>
                                    @if (!$loop->last)
                                        <span class="mx-1 text-gray-400">→</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="mt-6 text-sm text-gray-400">لا توجد تصنيفات مرتبطة بهذه الفتوى.</p>
                @endif


                {{-- تعيين شيخ من قبل المدير عندما لا توجد إجابة --}}
                @role('admin')
                    @if(!$fatwa->answer)
                        <div class="mt-8">
                            <form method="POST" action="{{ route('admin.fatwas.assign', $fatwa) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="sheikh_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">تعيين شيخ للإجابة:</label>
                                    <select name="sheikh_id" id="sheikh_id" class="form-select w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">-- اختر شيخاً --</option>
                                        @foreach(\App\Models\User::role('sheikh')->get() as $sheikh)
                                            <option value="{{ $sheikh->id }}" {{ $fatwa->sheikh_id == $sheikh->id ? 'selected' : '' }}>
                                                {{ $sheikh->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        <i class="fas fa-user-check me-2"></i> تعيين الشيخ
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        {{-- تنبيه بعدم إمكانية التعيين --}}
                        <div class="mt-8">
                            <div class="bg-yellow-100 dark:bg-yellow-700/20 border border-yellow-400 dark:border-yellow-600 text-yellow-800 dark:text-yellow-300 rounded p-4">
                                <i class="fas fa-info-circle me-2"></i>
                                تمت الإجابة على هذه الفتوى، لا يمكن تعيين شيخ آخر.
                            </div>
                        </div>
                    @endif
                @endrole

                {{-- نموذج إجابة الشيخ --}}
                @if(auth()->id() === $fatwa->sheikh_id && !$fatwa->answer)
                    <div class="mt-10 pt-6 border-t border-gray-300 dark:border-gray-700">
                        <form method="POST" action="{{ route('sheikh.fatwas.answer', $fatwa) }}" class="space-y-6">
                            @csrf

                            <div>
                                <label for="answer" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">الإجابة على الفتوى:</label>
                                <textarea name="answer" id="answer" rows="4" class="form-textarea w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500" required></textarea>
                            </div>

                            @php
                                // جلب التصنيفات الأساسية لإظهارها في القائمة عند تحميل الصفحة
                                $categories = \App\Models\Category::whereNull('parent_id')->get();
                            @endphp

                            <div id="category-wrapper" class="space-y-4">
                                <div class="category-level" data-level="0">
                                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">التصنيف:</label>

                                    <select name="categories[]" id="category-select-0" class="form-select w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">-- اختر تصنيفاً --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="mt-2 flex space-x-2">
                                        <input type="text" id="new-category-name-0" class="form-input rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white flex-grow" placeholder="أدخل تصنيف جديد">
                                        <button type="button" data-parent-id="" data-level="0" class="btn-add-category px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">إضافة</button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    <i class="fas fa-paper-plane me-2"></i> إرسال الإجابة
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('category-wrapper');

    // حدث لإضافة تصنيف جديد
    wrapper.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-add-category')) return;

        const btn = e.target;
        const level = parseInt(btn.dataset.level);
        const parentId = btn.dataset.parentId || null;
        const input = document.getElementById('new-category-name-' + level);
        const select = document.getElementById('category-select-' + level);

        const newName = input.value.trim();
        if (!newName) {
            alert('يرجى إدخال اسم التصنيف الجديد');
            return;
        }

        fetch('/categories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name: newName, parent_id: parentId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.id) {
                const option = document.createElement('option');
                option.value = data.id;
                option.textContent = data.name;
                option.selected = true;
                select.appendChild(option);

                input.value = '';

                // حذف المستويات الفرعية التي تلي المستوى الحالي
                const levels = Array.from(wrapper.querySelectorAll('.category-level'));
                for(let i = levels.length -1; i > level; i--) {
                    levels[i].remove();
                }

                // إضافة المستوى التالي مع parentId الجديد
                createNextLevel(level + 1, data.id);
            } else {
                alert('حدث خطأ أثناء إضافة التصنيف');
            }
        })
        .catch(() => {
            alert('خطأ في الاتصال بالخادم');
        });
    });

    // حدث عند اختيار تصنيف من القائمة
    wrapper.addEventListener('change', function (e) {
        if (!e.target.classList.contains('form-select')) return;

        const select = e.target;
        const level = parseInt(select.closest('.category-level').dataset.level);
        const selectedValue = select.value;

        // حذف كل المستويات التي تلي المستوى الحالي
        const levels = Array.from(wrapper.querySelectorAll('.category-level'));
        for(let i = levels.length -1; i > level; i--) {
            levels[i].remove();
        }

        if(selectedValue) {
            createNextLevel(level + 1, selectedValue);
        }
    });

    // دالة لإنشاء مستوى جديد (تصنيف فرعي)
    function createNextLevel(level, parentId) {
        // منع إضافة نفس المستوى أكثر من مرة
        if(wrapper.querySelector(`.category-level[data-level="${level}"]`)) {
            return;
        }

        const div = document.createElement('div');
        div.classList.add('category-level', 'mt-4');
        div.dataset.level = level;

        const label = document.createElement('label');
        label.className = 'block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300';
        label.textContent = `تصنيف فرعي (المستوى ${level + 1}):`;

        const select = document.createElement('select');
        select.name = 'categories[]';
        select.id = 'category-select-' + level;
        select.className = 'form-select w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500';
        select.innerHTML = `<option value="">-- اختر تصنيفاً --</option>`;

        const input = document.createElement('input');
        input.type = 'text';
        input.id = 'new-category-name-' + level;
        input.placeholder = 'أدخل تصنيف جديد';
        input.className = 'form-input rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white flex-grow mt-2';

        const btnAdd = document.createElement('button');
        btnAdd.type = 'button';
        btnAdd.className = 'btn-add-category px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2';
        btnAdd.textContent = 'إضافة';
        btnAdd.dataset.level = level;
        btnAdd.dataset.parentId = parentId;

        div.appendChild(label);
        div.appendChild(select);
        div.appendChild(input);
        div.appendChild(btnAdd);

        wrapper.appendChild(div);

        // جلب التصنيفات بناءً على parentId
        let url = '/categories';
        if(parentId === null || parentId === 'null' || parentId === '') {
            url += '?parent_id=null';
        } else {
            url += `?parent_id=${parentId}`;
        }

        fetch(url)
            .then(res => res.json())
            .then(categories => {
                categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    select.appendChild(option);
                });
            });
    }
});
</script>
