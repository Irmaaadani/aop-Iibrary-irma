<?php
// app\Http\Controllers\LoanController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;

class LoanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $books = Book::all();
        $members = User::where('role', 'member')->get();
        $loanQuery = Loan::with(['book', 'member']);

        // FILTER BERDASARKAN ROLE
        if ($user->role === 'librarian') {
            $loanQuery->where('librarian_id', $user->id);
        } elseif ($user->role === 'member') {
            $loanQuery->where('member_id', $user->id);
        }

        // admin → tidak difilter
        $loans = $loanQuery->get();

        return view('loans.index', compact('books', 'loans', 'members'));
    }

    public function data()
    {
        $user = auth()->user();

        $query = Loan::with(['book', 'member']);

        if ($user->role === 'librarian') {
            $query->where('librarian_id', $user->id);
        } elseif ($user->role === 'member') {
            $query->where('member_id', $user->id);
        }

        return response()->json([
            'status' => true,
            'data' => $query->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'    => 'required|exists:books,id',
            'member_id'  => 'required|exists:users,id',
            'returned_at'=> 'nullable|date',
            'note'       => 'nullable',
        ]);

        // apakah buku sedang dipinjam?
        $isBookOnLoan = Loan::where('book_id', $request->book_id)
            ->where(function ($q) {
                $q->whereNull('returned_at')
                ->orWhere('returned_at', '>=', now()->toDateString());
            })
            ->exists();

        if ($isBookOnLoan) {
            return response()->json([
                'status'  => false,
                'message' => 'Buku sedang dipinjam'
            ], 422);
        }

        // BOLEH DIPINJAM
        $loan = Loan::create([
            'book_id'      => $request->book_id,
            'librarian_id' => auth()->id(),
            'member_id'    => $request->member_id,
            'loan_at'      => now(),
            'returned_at'  => $request->returned_at,
            'note'         => $request->note,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Peminjaman berhasil ditambahkan'
        ]);
    }


    public function update(Request $request, $id)
    {
        Loan::findOrFail($id)->update([
            'note' => $request->note
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        Loan::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil dihapus'
        ]);
    }
}


