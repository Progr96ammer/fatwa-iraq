<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    $parentId = $request->query('parent_id');

    if ($parentId === 'null' || $parentId === null) {
        $categories = Category::whereNull('parent_id')->get();
    } else {
        $categories = Category::where('parent_id', $parentId)->get();
    }

    return response()->json($categories);
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    $category = Category::create([
        'name' => $request->name,
        'parent_id' => $request->parent_id,
    ]);

    return response()->json($category);
}
}
