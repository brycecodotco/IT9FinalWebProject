<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowManagementController extends Controller
{
    public function index()
    {
        $transactions = BorrowTransaction::with(['user', 'book'])->latest()->get();
        return view('admin.borrows.index', compact('transactions'));
    }

    public function approve(Request $request, BorrowTransaction $transaction)
    {
        // Require the admin to specify how many days the student gets the book
        $request->validate(['due_days' => 'required|integer|min:1']);

        $transaction->update([
            'approval_status' => 'Approved',
            'status' => 'Active',
            'borrow_date' => now(),
            'due_date' => now()->addDays((int) $request->due_days),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Request Approved. Book is now checked out to the student.');
    }

    public function reject(BorrowTransaction $transaction)
    {
        $transaction->update(['approval_status' => 'Rejected', 'status' => 'Returned']);
        
        // Add the copy back to the shelf since it was denied
        $transaction->book->increment('available_copies');
        $transaction->book->update(['status' => 'Available']);

        return back()->with('success', 'Request Rejected. Book returned to available stock.');
    }

    public function returnBook(BorrowTransaction $transaction)
    {
        if ($transaction->status !== 'Active') {
            return back()->with('error', 'This book is not currently active.');
        }

        // 1. Update the transaction
        $transaction->update([
            'status' => 'Returned',
            'return_date' => now(),
        ]);

        // 2. Add the physical book back to the shelf
        $transaction->book->increment('available_copies');
        $transaction->book->update(['status' => 'Available']);

        return back()->with('success', 'Book successfully marked as returned and restocked!');
    }
}