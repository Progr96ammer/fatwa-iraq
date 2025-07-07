<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fatwa;
use App\Models\User;
use App\Notifications\SheikhAssigned;

class FatwaController extends Controller
{
    public function index()
    {
        $fatwas = Fatwa::where('status', 'pending')->get();
        $sheikhs = User::role('sheikh')->get();
        return view('admin.fatwas.index', compact('fatwas', 'sheikhs'));
    }

    // عرض الفتاوى غير الموكلة
    public function unassigned()
    {
        $fatwas = Fatwa::whereNull('sheikh_id')->latest()->get();
        $sheikhs = User::role('sheikh')->get();

        return view('admin.fatwas.unassigned', compact('fatwas', 'sheikhs'));
    }

    public function assign(Request $request, Fatwa $fatwa)
    {
        $request->validate(['sheikh_id' => 'required|exists:users,id']);
        $fatwa->update([
            'sheikh_id' => $request->sheikh_id,
            'status' => 'assigned',
        ]);

        // إرسال إشعار للشيخ
        $sheikh = User::find($request->sheikh_id);
        $sheikh->notify(new SheikhAssigned($fatwa));

        return back()->with('success', 'تم تعيين الشيخ بنجاح.');
    }
}
