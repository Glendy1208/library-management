<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_it_can_create_a_book()
    {
        $author = Author::factory()->create();

        $data = [
            'title' => 'New Book',
            'description' => 'A very interesting book',
            'publish_date' => '2023-10-10',
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data']);

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_retrieve_books()
    {
        Book::factory()->count(5)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_update_a_book()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'publish_date' => '2022-05-05',
            'author_id' => $book->author_id,
        ];

        $response = $this->putJson("/api/books/{$book->id}", $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Book update successfully']);

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Book deleted successfully']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_retrieve_books_by_author()
    {
        $author = Author::factory()->create();
        Book::factory()->count(3)->create(['author_id' => $author->id]);

        $response = $this->getJson("/api/authors/{$author->id}/books");

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
