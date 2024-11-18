<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_it_can_create_an_author()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'A famous author',
            'birth_date' => '1990-01-01',
        ];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'data']);

        $this->assertDatabaseHas('authors', $data);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_retrieve_authors()
    {
        Author::factory()->count(3)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_update_an_author()
    {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'bio' => 'Updated Bio',
            'birth_date' => '1980-01-01',
        ];

        $response = $this->putJson("/api/authors/{$author->id}", $data);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Author Updated successfully']);

        $this->assertDatabaseHas('authors', $data);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_can_delete_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Author deleted successfully']);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}