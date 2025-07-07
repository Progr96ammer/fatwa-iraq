<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatwa;
use App\Models\News;
use App\Models\Book;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
{
    try {
        $query = trim($request->get('query'));

        if (empty($query)) {
            return response()->json([]);
        }

        // بحث في الكتب
        $books = Book::where('title', 'like', "%{$query}%")
            ->select('id', 'title')
            ->limit(5)
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'type' => 'book',
                ];
            });

        // بحث في الأخبار
        $news = News::where('title', 'like', "%{$query}%")
            ->select('id', 'title')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'news',
                ];
            });

        // بحث في الفتاوى
        $fatwas = Fatwa::where('question', 'like', "%{$query}%")
            ->select('id', 'question as title')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'fatwa',
                ];
            });

        // دمج النتائج (كلها Collections)
        $results = collect()
            ->merge($books)
            ->merge($news)
            ->merge($fatwas)
            ->values(); // ترتيب الفهارس

        return response()->json($results);
    } catch (\Throwable $e) {
        Log::error('Autocomplete Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
}
