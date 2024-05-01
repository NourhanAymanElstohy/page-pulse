<?php

namespace App\Services;

use App\Models\Book;

class RecommendationService
{
    public function getMostRecommendedBooksBasedOnHowManyUniquePagesHaveBeenRead($intervals)
    {
        $booksReadPages = $this->calculateBooksReadPages($intervals);
        $booksReadPages = $this->sortBooksReadPages($booksReadPages);
        $mostRecommendedBooks = $this->getTopRecommendedBooks($booksReadPages);

        return $mostRecommendedBooks;
    }

    private function calculateBooksReadPages($intervals)
    {
        $booksReadPages = [];

        foreach ($intervals as $interval) {
            for ($i = $interval->start_page; $i <= $interval->end_page; $i++) {
                $booksReadPages[$interval->book_id][$i] = true;
            }
        }

        return array_map('count', $booksReadPages);
    }

    private function sortBooksReadPages($booksReadPages)
    {
        arsort($booksReadPages);
        return $booksReadPages;
    }

    private function getTopRecommendedBooks($booksReadPages)
    {
        $mostRecommendedBooks = [];
        $i = 0;

        foreach ($booksReadPages as $book_id => $read_pages) {
            $book = Book::find($book_id);
            $mostRecommendedBooks[] = [
                'book_id' => $book->id,
                'book_name' => $book->name,
                'read_pages' => $read_pages - 1
            ];
            $i++;
            if ($i == 5) {
                break;
            }
        }

        return $mostRecommendedBooks;
    }
}
