<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['category_name' => 'required|string|max:255|unique:categories,category_name']);
        Category::create(['category_name' => $request->category_name]);
        return back()->with('success', 'Category added successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Cannot delete category because it contains books.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}