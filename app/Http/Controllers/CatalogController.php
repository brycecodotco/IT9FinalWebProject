<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category']);

        // 1. Text Search (Wrapped in a logical group so it doesn't break filters)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', fn($q2) => $q2->where('author_name', 'like', "%{$search}%"))
                  ->orWhereHas('category', fn($q2) => $q2->where('category_name', 'like', "%{$search}%"));
            });
        }

        // 2. Filter by Specific Author
        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        // 3. Filter by Specific Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->get();
        
        // Fetch authors and categories for the dropdown menus
        $authors = Author::orderBy('author_name')->get();
        $categories = Category::orderBy('category_name')->get();

        return view('catalog.index', compact('books', 'authors', 'categories'));
    }
}