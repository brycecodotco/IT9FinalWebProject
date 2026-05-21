<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 1. View Inventory List
    public function index()
    {
        $books = Book::with(['author', 'category'])->latest()->get();
        return view('admin.books.index', compact('books'));
    }

    // 2. View Bulk Create Form
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.create', compact('authors', 'categories'));
    }

    // 3. Handle Bulk Insert
    public function store(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.title' => 'required|string|max:255',
            'books.*.author_id' => 'required|exists:authors,id',
            'books.*.category_id' => 'required|exists:categories,id',
            'books.*.isbn' => 'required|string|distinct|unique:books,isbn',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image
        ]);

        foreach ($request->books as $index => $bookData) {
            $coverPath = null;
            // Check if file was uploaded for this specific row
            if ($request->hasFile("books.{$index}.cover")) {
                $coverPath = $request->file("books.{$index}.cover")->store('book_covers', 'public');
            }

            Book::create([
                'title' => $bookData['title'],
                'author_id' => $bookData['author_id'],
                'category_id' => $bookData['category_id'],
                'isbn' => $bookData['isbn'],
                'quantity' => $bookData['quantity'],
                'available_copies' => $bookData['quantity'],
                'cover_image' => $coverPath, // Save path to DB
                'status' => 'Available',
            ]);
        }
        return redirect()->route('admin.books.index')->with('success', count($request->books) . ' books added successfully!');
    }

    // 4. Delete Book
    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Book removed from inventory.');
    }

    // 5. View Bulk Edit Form (Spreadsheet Style)
    public function bulkEdit()
    {
        $books = Book::all(); // Fetches all books for the spreadsheet
        $authors = Author::all();
        $categories = Category::all();

        return view('admin.books.bulk-edit', compact('books', 'authors', 'categories'));
    }

    // 6. Handle Bulk Update
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.id' => 'required|exists:books,id',
            'books.*.title' => 'required|string|max:255',
            'books.*.author_id' => 'required|exists:authors,id',
            'books.*.category_id' => 'required|exists:categories,id',
            'books.*.isbn' => 'required|string',
            'books.*.quantity' => 'required|integer|min:1',
            'books.*.cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Added Image Validation
        ]);

        foreach ($request->books as $index => $bookData) {
            $book = Book::find($bookData['id']);
            
            // Smart Math: Adjust available copies based on the change in total quantity
            $quantityDifference = $bookData['quantity'] - $book->quantity;
            $newAvailableCopies = $book->available_copies + $quantityDifference;

            // Prevent lowering quantity below what is currently checked out
            if ($newAvailableCopies < 0) {
                return back()->with('error', 'Cannot reduce quantity for "' . $book->title . '" because copies are currently borrowed.');
            }

            // Handle New Image Upload (if provided)
            if ($request->hasFile("books.{$index}.cover")) {
                $coverPath = $request->file("books.{$index}.cover")->store('book_covers', 'public');
                $book->cover_image = $coverPath;
            }

            $book->update([
                'title' => $bookData['title'],
                'author_id' => $bookData['author_id'],
                'category_id' => $bookData['category_id'],
                'isbn' => $bookData['isbn'],
                'quantity' => $bookData['quantity'],
                'available_copies' => $newAvailableCopies,
                'status' => $newAvailableCopies > 0 ? 'Available' : 'Borrowed',
                'cover_image' => $book->cover_image, // Ensures new image path is saved
            ]);
        }

        return redirect()->route('admin.books.index')->with('success', 'Inventory updated successfully!');
    }
}