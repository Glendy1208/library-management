<?php

namespace Database\Seeders;

use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // SEEDER AUTHORS
        $a1 = 'bed2e708-b2b3-497d-9ae4-69e6040beb92';
        $a2 = 'd05735f1-2a02-41a8-80fd-03cbdb485d15';
        $a3 = 'd99f586e-af31-42f0-98ce-1073cf06866e';
        Author::create([
            'id' => $a1,
            'name' => 'J.K. Rowling',
            'bio' => 'Joanne Rowling CH, OBE, HonFRSE, FRCPE, FRSL, better known by her pen name J. K. Rowling, is a British author and philanthropist. She is best known for writing the Harry Potter fantasy series, which has won multiple awards and sold more than 500 million copies, becoming the best-selling book series in history.',
            'birth_date' => '1965-07-31',
        ]);
        Author::create([
            'id' => $a2,
            'name' => 'J.R.R. Tolkien',
            'bio' => 'John Ronald Reuel Tolkien CBE FRSL was an English writer, poet, philologist, and academic, best known as the author of the high fantasy works The Hobbit and The Lord of the Rings.',
            'birth_date' => '1892-01-03',
        ]);
        Author::create([
            'id' => $a3,
            'name' => 'George R.R. Martin',
            'bio' => 'George Raymond Richard Martin, also known as GRRM, is an American novelist and short story writer in the fantasy, horror, and science fiction genres, screenwriter, and television producer. He is best known for his series of epic fantasy novels, A Song of Ice and Fire, which was adapted into the HBO series Game of Thrones.',
            'birth_date' => '1948-09-20',
        ]);

        // SEEDER BOOKS
        Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'Harry Potter has been living a dull life with the Dursleys, but on his eleventh birthday, he learns he is a wizard and is to attend Hogwarts School of Witchcraft and Wizardry.',
            'publish_date' => '1997-06-26',
            'author_id' => $a1,
        ]);
        Book::create([
            'title' => 'Harry Potter and the Chamber of Secrets',
            'description' => 'Harry Potter is in his second year of Hogwarts School of Witchcraft and Wizardry. He is visited by a house-elf named Dobby and warned not to go back to Hogwarts.',
            'publish_date' => '1998-07-02',
            'author_id' => $a1,
        ]);
        Book::create([
            'title' => 'The Hobbit',
            'description' => 'The Hobbit is set within Tolkien\'s fictional universe and follows the quest of home-loving Bilbo Baggins, the titular hobbit, to win a share of the treasure guarded by Smaug the dragon.',
            'publish_date' => '1937-09-21',
            'author_id' => $a2,
        ]);
        Book::create([
            'title' => 'A Game of Thrones',
            'description' => 'A Game of Thrones is the first novel in A Song of Ice and Fire, a series of fantasy novels by the American author George R. R. Martin.',
            'publish_date' => '1996-08-06',
            'author_id' => $a3,
        ]);
        
    }
}
