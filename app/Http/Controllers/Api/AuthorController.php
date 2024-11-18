<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of all author.
     */
    public function index()
    {
        $authors = Author::all();
        if ($authors->isEmpty()) {
            return response()->json(['message' => 'No authors found'], 404);
        } else {   
            return AuthorResource::collection($authors);
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

        $data = Author::create([
            'name' => $request['name'],
            'bio' => $request['bio'],
            'birth_date' => $request['birth_date'],
        ]);

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
            return response()->json(['message' => 'Author deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Author cannot be deleted, because has books recored'], 403);
        }
    }
}
