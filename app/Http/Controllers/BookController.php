<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Interval;
use App\Models\User;
use App\Services\RecommendationService;
use App\Services\SMsService;
use App\Traits\RespondsWithHttpStatus;

class BookController extends Controller
{
    private $recommendationService;

    use RespondsWithHttpStatus;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    function submitUserInterval(BookRequest $request)
    {
        $user = User::find($request->user_id);
        Interval::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'start_page' => $request->start_page,
            'end_page' => $request->end_page
        ]);

        return $this->sendResponse([], 'Interval submitted successfully.');
    }

    function getMostRecommendedBooks()
    {
        $intervals = Interval::with('book')->get();
        $mostRecommendedBooks = $this->recommendationService->getMostRecommendedBooksBasedOnHowManyUniquePagesHaveBeenRead($intervals);
        return $this->sendResponse($mostRecommendedBooks, 'Most 5 recommended books fetched successfully.');
    }
}
