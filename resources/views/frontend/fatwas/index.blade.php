<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                {{-- العنوان والزر --}}
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">الفتاوى المجاب عنها</h2>
                    <button id="toggleViewBtn"
                            onclick="toggleTreeView()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-md shadow transition">
                        📂 العرض الشجري
                    </button>
                </div>

                {{-- جدول الفتاوى --}}
                <div id="tableView" class="p-6 overflow-x-auto">
                    <table id="myTable" class="min-w-[750px] w-full text-sm text-right text-gray-700 dark:text-gray-200 rtl">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <tr>
                                <th class="px-6 py-3">رقم الفتوى</th>
                                <th class="px-6 py-3">السؤال</th>
                                <th class="px-6 py-3">الجواب المختصر</th>
                                <th class="px-6 py-3">القسم</th>
                                @role('admin')
                                    <th class="px-6 py-3">الشيخ</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($fatwas as $fatwa)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition cursor-pointer"
                                    onclick="window.location='{{ route('fatwas.show', $fatwa) }}'">
                                    <td class="px-6 py-3 text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $fatwa->answer }}">
                                        {{ Str::limit($fatwa->id, 100) }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $fatwa->question }}">
                                        {{ Str::limit($fatwa->question, 100) }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $fatwa->answer }}">
                                        {{ Str::limit($fatwa->answer, 100) }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        @foreach($fatwa->categories as $category)
                                            <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    @role('admin')
                                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                            {{ optional($fatwa->sheikh)->name ?? 'غير محدد' }}
                                        </td>
                                    @endrole
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                        لا توجد فتاوى مجاب عنها حالياً.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- روابط التصفح --}}
                <div id="paginationView" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-center">
                    {{ $fatwas->links('pagination::tailwind') }}
                </div>

                {{-- العرض الشجري --}}
                <div id="treeView" class="p-6 hidden">
                    <style>
                        .tree-folder::before { content: "📁 "; margin-left: 0.25rem; }
                        .tree-file::before { content: "📄 "; margin-left: 0.25rem; }
                        .tree-item { margin-right: 1rem; padding-right: 0.5rem; border-right: 2px solid #e5e7eb; }
                        .toggle-btn { cursor: pointer; font-weight: 600; margin-bottom: 4px; display: inline-block; transition: color 0.2s ease; }
                        .toggle-btn:hover { color: #2563eb; }
                        .tree-file:hover { color: #1e40af; text-decoration: underline; }
                    </style>

                    <div class="bg-white dark:bg-gray-900 space-y-3 text-right text-gray-800 dark:text-gray-100">
                        @php
                            function renderTree($categories)
                            {
                                foreach ($categories as $category) {
                                    echo '<div class="tree-item">';
                                    echo '<div class="toggle-btn tree-folder" onclick="toggleNode(\'cat-' . $category->id . '\'); toggleNode(\'cat-' . $category->id . '-fatwas\')">';
                                    echo e($category->name);
                                    echo '</div>';

                                    // فتاوى هذا التصنيف (التي ينتمي لها كـ أعمق تصنيف فقط)
                                    if ($category->fatwas->count()) {
                                        echo '<div id="cat-' . $category->id . '-fatwas" class="ml-6 hidden space-y-2">';
                                        foreach ($category->fatwas as $fatwa) {
                                            // استخراج أعمق تصنيف مرتبط بهذه الفتوى
                                            $deepestCategory = $fatwa->categories->sortByDesc(function ($cat) {
                                                $depth = 0;
                                                $current = $cat;
                                                while ($current->parent) {
                                                    $depth++;
                                                    $current = $current->parent;
                                                }
                                                return $depth;
                                            })->first();

                                            // عرض الفتوى فقط إن كان هذا التصنيف هو الأعمق
                                            if ($deepestCategory && $deepestCategory->id == $category->id) {
                                                echo '<div class="ml-6 text-sm tree-file cursor-pointer" onclick="window.location=\'' . route('fatwas.show', $fatwa) . '\'">';
                                                echo e(Str::limit($fatwa->question, 80));
                                                echo '</div>';
                                            }
                                        }
                                        echo '</div>';
                                    }

                                    // التصنيفات الفرعية
                                    if ($category->children->count()) {
                                        echo '<div id="cat-' . $category->id . '" class="ml-6 hidden space-y-2">';
                                        renderTree($category->children);
                                        echo '</div>';
                                    }

                                    echo '</div>';
                                }
                            }

                            renderTree($categories);
                        @endphp
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- سكربت العرض الشجري --}}
    <script>
        function toggleTreeView() {
            const tableView = document.getElementById('tableView');
            const paginationView = document.getElementById('paginationView');
            const treeView = document.getElementById('treeView');
            const toggleBtn = document.getElementById('toggleViewBtn');

            const isTreeVisible = !treeView.classList.contains('hidden');

            if (isTreeVisible) {
                // الرجوع إلى العرض المجدول
                treeView.classList.add('hidden');
                tableView.classList.remove('hidden');
                paginationView?.classList.remove('hidden');
                toggleBtn.innerHTML = '📂 العرض الشجري';
            } else {
                // التبديل إلى العرض الشجري
                treeView.classList.remove('hidden');
                tableView.classList.add('hidden');
                paginationView?.classList.add('hidden');
                toggleBtn.innerHTML = '📋 العرض المجدول';
            }
        }

        function toggleNode(id) {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
