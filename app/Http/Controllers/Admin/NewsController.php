<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::where('id', $id)->firstOrFail();
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image')?->store('news', 'public');

        News::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imagePath,
        ]);

        return redirect()->route('news.index')->with('success', 'تم إضافة الخبر');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $news->image = $request->file('image')->store('news', 'public');
        }

        $news->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $news->image,
        ]);

        return redirect()->route('news.index')->with('success', 'تم التحديث');
    }

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();
        return back()->with('success', 'تم الحذف');
    }
}
