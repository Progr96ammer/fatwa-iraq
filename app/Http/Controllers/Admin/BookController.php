<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('admin.books.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }


    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'cover' => 'nullable|image|max:2048',
            'file' => 'required|mimes:pdf|max:10000',
        ]);

        $coverPath = $request->file('cover')?->store('books/covers', 'public');
        $filePath = $request->file('file')->store('books/files', 'public');

        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $coverPath,
            'file' => $filePath,
        ]);

        return redirect()->route('books.index')->with('success', 'تم إضافة الكتاب');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'cover' => 'nullable|image|max:2048',
            'file' => 'nullable|mimes:pdf|max:10000',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $book->cover = $request->file('cover')->store('books/covers', 'public');
        }

        if ($request->hasFile('file')) {
            if ($book->file) Storage::disk('public')->delete($book->file);
            $book->file = $request->file('file')->store('books/files', 'public');
        }

        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover' => $book->cover,
            'file' => $book->file,
        ]);

        return redirect()->route('books.index')->with('success', 'تم التحديث');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) Storage::disk('public')->delete($book->cover);
        if ($book->file) Storage::disk('public')->delete($book->file);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'تم الحذف');
    }
}
