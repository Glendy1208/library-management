<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    /**
     * Display a listing of all author.
     */
    public function index()
    {
        $authors = Cache::remember('authors_list', now()->addMinutes(10), function () {
            return Author::select('id', 'name')->get();
        });

        if ($authors->isEmpty()) {
            return response()->json(['message' => 'No authors found'], 404);
        } else {   
            return response()->json($authors, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'birth_date' => 'required|date',
        ]);
        
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        $existingAuthor = Author::where('name', $request['name'])->first();
        if ($existingAuthor) {
            return response()->json([
            'message' => 'Author with this name already exists',
            ], 409);
        }

        $data = Author::create([
            'name' => $request['name'],
            'bio' => $request['bio'],
            'birth_date' => $request['birth_date'],
        ]);

        Cache::forget('authors_list');

        return response()->json([
            'message' => 'Author created successfully',
            'data' => new AuthorResource($data),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $id)
    {
        return new AuthorResource($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'birth_date' => 'required|date',
        ]);
        
        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validatedData->errors(),
            ], 422);
        } 

        $id->update([
            'name' => $request['name'],
            'bio' => $request['bio'],
            'birth_date' => $request['birth_date'],
        ]);

        Cache::forget("author_{$id->id}_books");
        Cache::forget('authors_list');

        return response()->json([
            'message' => 'Author Updated successfully',
            'data' => new AuthorResource($id),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $id)
    {
        try {
            $id->delete();

            Cache::forget("author_{$id->id}_books");
            Cache::forget('authors_list');

            return response()->json(['message' => 'Author deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Author cannot be deleted, because has books recored'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function books(Author $id)
    {
        $books = Cache::remember("author_{$id->id}_books", now()->addMinutes(10), function () use ($id) {
            return $id->book()->select('id', 'title', 'description', 'publish_date')->get();
        });
        if ($books->isEmpty()) {
            return response()->json(['message' => 'No books found for this author'], 404);
        } else {
            return response()->json($books, 200);
        }
    }
}
