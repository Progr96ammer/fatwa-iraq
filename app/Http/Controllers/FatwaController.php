<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatwa;
use App\Models\Category;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\NewFatwaSubmitted;

class FatwaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fatwas = Fatwa::where('status', 'answered')->latest()->paginate(10);

        // جلب التصنيفات الرئيسية مع الفروع والفتاوى المرتبطة بها
        $categories = Category::with(['children.fatwas', 'fatwas'])
                            ->whereNull('parent_id')
                            ->get();

        return view('frontend.fatwas.index', compact('fatwas', 'categories'));
    }

    public function show($id)
    {
        $fatwa = Fatwa::with('user')->findOrFail($id);
        return view('fatwas.show', compact('fatwa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.fatwas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000'
        ]);

        $fatwa = Fatwa::create([
            'user_id' => auth()->id(),
            'question' => $request->question,
        ]);

        // إرسال إشعار للمدير
        $adminUsers = User::role('admin')->get();
        Notification::send($adminUsers, new NewFatwaSubmitted($fatwa));

        return redirect()->back()->with('success', 'تم إرسال سؤالك وسيتم الرد قريبًا.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
