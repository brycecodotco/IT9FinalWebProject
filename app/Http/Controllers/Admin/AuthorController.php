<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->latest()->get();
        return view('admin.authors.index', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate(['author_name' => 'required|string|max:255|unique:authors,author_name']);
        Author::create(['author_name' => $request->author_name]);
        return back()->with('success', 'Author added successfully!');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return back()->with('error', 'Cannot delete author because they have books in the inventory.');
        }
        $author->delete();
        return back()->with('success', 'Author deleted.');
    }
}