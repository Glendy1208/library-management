<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;

class CaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_read_authors_empty()
    {
        Author::query()->delete();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(404)
                 ->assertJson(['message'=>'No authors found']);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_author_with_invalid_input()
    {
        $data = [
            // no field name submitted
            'bio' => 'A great author',
            'birth_date' => 'invalid-date-format',
        ];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(422); 

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'birth_date',
            ],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_author_with_existing_name()
    {
        $existingAuthor = Author::factory()->create([
            'name' => 'John Doe',
        ]);

        $data = [
            'name' => 'John Doe',
            'bio' => 'Duplicate author test',
            'birth_date' => '1980-05-15',
        ];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(409); 
        $response->assertJson([
            'message' => 'Author with this name already exists',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_show_author_record_not_found()
    {
        $nonExistentId = '00000000-0000-0000-0000-000000000000';

        $response = $this->getJson("/api/authors/{$nonExistentId}");

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Record Not Found',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_author_with_invalid_input()
    {
        $author = Author::factory()->create();
    
        $invalidData = [
            'name' => '', 
            'bio' => 'This is an updated bio.',
            'birth_date' => 'invalid-date-format', 
        ];
    
        $response = $this->putJson("/api/authors/{$author->id}", $invalidData);
    
        $response->assertStatus(422);
    
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'birth_date',
            ],
        ]);
    
        // make sure the author record was not updated
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => $author->name,
            'bio' => $author->bio,
            'birth_date' => $author->birth_date,
        ]);
    }
    
    /**
     * A basic feature test example.
     */
    public function test_author_cannot_be_deleted_if_has_books()
    {
        $author = Author::factory()->create();
        Book::factory()->create(['author_id' => $author->id]);
    
        $response = $this->deleteJson("/api/authors/{$author->id}");
    
        $response->assertStatus(403);
    
        $response->assertJson([
            'message' => 'Author cannot be deleted, because has books recored',
        ]);
    
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
        ]);
    
        // make sure the book record was not deleted
        $this->assertDatabaseHas('books', [
            'author_id' => $author->id,
        ]);
    }
    
    /**
     * A basic feature test example.
     */
    public function test_read_books_empty()
    {
        Book::query()->delete();

        $response = $this->getJson('/api/books');

        $response->assertStatus(404)
                 ->assertJson(['message'=>'No books found']);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_book_with_invalid_input()
    {
        $data = [
            // no field title submitted
            'description' => 'A great book',
            'publish_date' => 'invalid-date-format',
            'author_id' => 'invalid-uuid-format',
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(422); 

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'title',
                'publish_date',
                'author_id',
            ],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_book_with_existing_title()
    {
        $author = Author::factory()->create();
    
        $existingBook = Book::factory()->create([
            'title' => 'Existing Book Title',
            'author_id' => $author->id,
        ]);
    
        $data = [
            'title' => 'Existing Book Title', // Judul sama
            'description' => 'A duplicate book test',
            'publish_date' => '2023-10-10',
            'author_id' => $author->id,
        ];
    
        $response = $this->postJson('/api/books', $data);
    
        $response->assertStatus(409);
    
        $response->assertJson([
            'message' => 'Book with this title already exists',
        ]);
    
        // make sure the book record was not created
        $this->assertDatabaseCount('books', 1);
    }
    
    /**
     * A basic feature test example.
     */
    public function test_book_record_not_found()
    {
        $nonExistentId = '00000000-0000-0000-0000-000000000000';

        $response = $this->getJson("/api/books/{$nonExistentId}");

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Record Not Found',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_book_with_invalid_input()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
    
        $invalidData = [
            'title' => '', 
            'description' => 'Updated description.',
            'publish_date' => 'invalid-date', 
            'author_id' => 'invalid-author', 
        ];
    
        $response = $this->putJson("/api/books/{$book->id}", $invalidData);
    
        $response->assertStatus(422);
    
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'title',
                'publish_date',
                'author_id',
            ],
        ]);
    
        // make sure the book record was not updated
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $book->title, 
            'description' => $book->description,
            'publish_date' => $book->publish_date,
            'author_id' => $book->author_id,
        ]);
    }
    
}
