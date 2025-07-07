<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Book;
use \App\Models\Fatwa;
use \App\Models\Article;

class FrontendController extends Controller
{
    public function home()
    {
        return view('welcome', [
            'latestFatwas' => Fatwa::latest()->take(3)->get(),
            'latestNews'   => News::latest()->take(3)->get(),
            'latestBooks'  => Book::latest()->take(3)->get(),
            'latestArticles' => Article::latest()->take(5)->get(),
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        return view('dashboard', [
            'latestFatwas' => Fatwa::latest()->take(6)->get(),
            'latestNews' => News::latest()->take(6)->get(),
            'latestBooks' => Book::latest()->take(6)->get(),
            'latestArticles' => Article::latest()->take(5)->get(),

            // حسب الدور:
            'unassignedFatwas' => $user->hasRole('admin') ? Fatwa::whereNull('sheikh_id')->latest()->take(5)->get() : [],
            'unansweredAssignedFatwas' => $user->hasRole('sheikh') ? Fatwa::where('sheikh_id', $user->id)->whereNull('answer')->latest()->take(5)->get() : [],
            'answeredFatwas' => $user->hasRole('sheikh') ? Fatwa::where('sheikh_id', $user->id)->whereNotNull('answer')->latest()->take(5)->get() : [],
            'myFatwas' => $user->hasRole('user') ? Fatwa::where('user_id', $user->id)->latest()->take(5)->get() : [],
        ]);
    }
}
