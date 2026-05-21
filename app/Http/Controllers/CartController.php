<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // View the Cart
    public function index()
    {
        $cartIds = session()->get('cart', []);
        $books = Book::whereIn('id', $cartIds)->get();
        return view('catalog.cart', compact('books'));
    }

    // Add to Cart
    public function add(Book $book)
    {
        if ($book->available_copies <= 0) return back()->with('error', 'Book is out of stock.');
        
        $cart = session()->get('cart', []);
        if (!in_array($book->id, $cart)) {
            $cart[] = $book->id;
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Added to your borrow cart!');
    }

    // Remove from Cart
    public function remove(Book $book)
    {
        $cart = session()->get('cart', []);
        $cart = array_diff($cart, [$book->id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Removed from cart.');
    }

    // Checkout (Process all books in cart)
    public function checkout()
    {
        $cartIds = session()->get('cart', []);
        if (empty($cartIds)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $books = Book::whereIn('id', $cartIds)->get();

        foreach ($books as $book) {
            // Only process if the book is actually in stock
            if ($book->available_copies > 0) {
                
                // 1. Safe Math: Manually subtract 1
                $book->available_copies -= 1;
                
                // 2. If it hits 0, change status
                if ($book->available_copies <= 0) {
                    $book->status = 'Borrowed';
                }
                
                // 3. Save the book updates to the database
                $book->save();

                // 4. Create the pending request for the Employee
                BorrowTransaction::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'request_date' => now(),
                    'approval_status' => 'Pending',
                ]);
            }
        }

        // Clear the cart
        session()->forget('cart');
        
        return redirect()->route('catalog.index')->with('success', 'Borrow request submitted successfully! Waiting for admin approval.');
    }
}