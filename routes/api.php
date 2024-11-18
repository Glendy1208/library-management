<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authors API Endpoints
Route::get('/authors', [AuthorController::class, 'index']); // Retrieve a list of all authors
Route::get('/authors/{id}', [AuthorController::class, 'show']); // Retrieve details of a specific author
Route::post('/authors', [AuthorController::class, 'store']); // Create a new author
Route::put('/authors/{id}', [AuthorController::class, 'update']); // Update an existing author
Route::delete('/authors/{id}', [AuthorController::class, 'destroy']); // Delete an author

// Books API Endpoints
// Route::get('/books', [BookController::class, 'index']); // Retrieve a list of all books
// Route::get('/books/{id}', [BookController::class, 'show']); // Retrieve details of a specific book
// Route::post('/books', [BookController::class, 'store']); // Create a new book
// Route::put('/books/{id}', [BookController::class, 'update']); // Update an existing book
// Route::delete('/books/{id}', [BookController::class, 'destroy']); // Delete a book

// Associations API Endpoints
// Route::get('/authors/{id}/books', [AuthorController::class, 'books']); // Retrieve all books by a specific author