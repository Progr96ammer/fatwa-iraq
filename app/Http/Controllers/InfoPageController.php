<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoPageController extends Controller
{
    // ملفات المحتويات لكل صفحة
    private $files = [
        'about'   => 'about_us.txt',
        'vision'  => 'vision.txt',
        'goals'   => 'goals.txt',
        'summary' => 'summary.txt',
    ];

    // عرض الصفحة حسب المفتاح (slug)
    public function show($page)
    {
        if (!array_key_exists($page, $this->files)) {
            abort(404);
        }

        $filePath = $this->files[$page];

        $content = Storage::disk('local')->exists($filePath)
            ? Storage::disk('local')->get($filePath)
            : "لا يوجد محتوى لهذه الصفحة حتى الآن.";

        // عنوان الصفحة للعرض
        $titles = [
            'about'   => 'من نحن',
            'vision'  => 'الرؤية',
            'goals'   => 'الأهداف',
            'summary' => 'نبذة مختصرة',
        ];

        $title = $titles[$page];

        return view('info-page', compact('content', 'title', 'page'));
    }

    // تحديث المحتوى (فقط للمدير)
    public function update(Request $request, $page)
    {

        if (!array_key_exists($page, $this->files)) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $filePath = $this->files[$page];
        Storage::disk('local')->put($filePath, $request->input('content'));

        return redirect()->route('info.show', $page)->with('success', 'تم حفظ التعديلات بنجاح.');
    }
}
