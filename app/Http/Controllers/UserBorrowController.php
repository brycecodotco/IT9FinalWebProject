<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBorrowController extends Controller
{
   // View Student's Borrow History
    public function index()
    {
        // Fetch all transactions belonging to the logged-in student
        $transactions = BorrowTransaction::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.borrows.index', compact('transactions'));
    }

}
