<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Cache::remember('books_list', now()->addMinutes(10), function () {
            return Book::select('id', 'title')->get();
        });

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No books found'], 404);
        } else {
            return response()->json($books);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'author_id' => 'required|exists:authors,id',
        ]);
        
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 422);
        } 

        $existingBook = Book::where('title', $request['title'])->first();
        if ($existingBook) {
            return response()->json([
            'message' => 'Book with this title already exists',
            ], 409);
        }

        $data = Book::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'publish_date' => $request['publish_date'],
            'author_id' => $request['author_id'],
        ]);

        Cache::forget('books_list');

        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $id)
    {
        return new BookResource($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $id)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'author_id' => 'required|exists:authors,id',
        ]);
        
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 422);
        } 

        $id->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'publish_date' => $request['publish_date'],
            'author_id' => $request['author_id'],
        ]);

        Cache::forget('books_list');

        return response()->json([
            'message' => 'Book update successfully',
            'data' => new BookResource($id),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $id)
    {
        $id->delete();
        Cache::forget('authors_list');
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
