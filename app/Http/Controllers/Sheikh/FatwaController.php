<?php

namespace App\Http\Controllers\Sheikh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fatwa;
use App\Notifications\FatwaAnswered;
use App\Models\User;

class FatwaController extends Controller
{
    public function index()
    {
        $fatwas = Fatwa::where('sheikh_id', auth()->id())->where('status', 'assigned')->get();
        return view('sheikh.fatwas.index', compact('fatwas'));
    }

    public function answer(Request $request, Fatwa $fatwa)
    {
        $request->merge([
        'categories' => array_filter($request->categories)
        ]);

        $request->validate([
            'answer' => 'required|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);
        // تحديث الفتوى نفسها
        $fatwa->update([
            'answer' => $request->answer,
            'status' => 'answered',
        ]);

        // ربط التصنيفات المختارة بالفتوى
        $fatwa->categories()->sync(array_filter($request->categories));

        // إرسال إشعار للمستخدم
        $user = User::find($fatwa->user_id);
        $user->notify(new FatwaAnswered($fatwa));

        return back()->with('success', 'تم إرسال الجواب.');
    }
}
