<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $data_books = Book::all();
        $categories = Category::all();
        return view('books.index', ['data_books' => $data_books, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
    $request->validate([
        'title' => 'required',
        'author' => 'required',
        'isbn' => 'required',
        'description' => 'required',
        'categories' => 'required|array'
    ]);

    $book = Book::create($request->only('title','author','isbn','description'));
    $book->categories()->sync($request->categories);

    return response()->json([
        'status' => true,
        'message' => 'Buku berhasil ditambahkan'
    ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->only('title','author','isbn','description'));
        $book->categories()->sync($request->categories);

        return response()->json([
            'status' => true,
            'message' => 'Buku berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}
