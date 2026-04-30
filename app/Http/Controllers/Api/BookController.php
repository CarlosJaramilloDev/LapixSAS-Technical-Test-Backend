<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|integer|min:0',
            'stock' => 'prohibited',
        ]);
        $book->update($validated);
        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }

    /**
     * Update stock safely using database transactions and pessimistic locking.
     */
    public function updateStock(Request $request, Book $book)
    {
        $request->validate([
            'amount' => 'required|integer',
        ]);

        try {
            $updatedBook = DB::transaction(function () use ($book, $request) {

                $currentBook = Book::whereKey($book->getKey())
                    ->lockForUpdate()
                    ->first();

                $currentStock = (int) $currentBook->getAttribute('stock');
                $newStock = $currentStock + (int) $request->input('amount');

                if ($newStock < 0) {
                    throw new \Exception("Operation failed: Insufficient stock available.");
                }

                $currentBook->setAttribute('stock', $newStock);
                $currentBook->save();

                return $currentBook;
            });

            return response()->json([
                'message' => 'Stock updated successfully.',
                'book' => $updatedBook
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
