<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Interval;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;


    public function test_submit_user_interval()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['num_of_pages' => 100]);
        $validData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_page' => 10,
            'end_page' => 30,
        ];
        $invalidData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_page' => 1,
            'end_page' => 150,
        ];

        $response = $this->post('/api/submit-user-interval', $validData);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Interval submitted successfully.');

        $response = $this->json('POST', '/api/submit-user-interval', $invalidData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'end_page' => 'The end_page must be less than or equal to 100.',
        ]);
    }

    public function test_get_most_recommended_books()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        Interval::factory()->create(['user_id' => $user1->id, 'book_id' => $book1->id, 'start_page' => 10, 'end_page' => 30]);
        Interval::factory()->create(['user_id' => $user2->id, 'book_id' => $book1->id, 'start_page' => 2, 'end_page' => 25]);

        Interval::factory()->create(['user_id' => $user1->id, 'book_id' => $book2->id, 'start_page' => 40, 'end_page' => 50]);
        Interval::factory()->create(['user_id' => $user2->id, 'book_id' => $book2->id, 'start_page' => 1, 'end_page' => 10]);

        $response = $this->get('/api/get-most-recommended-books');
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Most 5 recommended books fetched successfully.');
    }
}
