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
    private $smsService;

    use RespondsWithHttpStatus;

    public function __construct(RecommendationService $recommendationService, SMsService $smsService)
    {
        $this->recommendationService = $recommendationService;
        $this->smsService = $smsService;
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

        $this->sendThankYouSms($user);
        return $this->sendResponse([], 'Interval submitted successfully.');
    }

    function getMostRecommendedBooks()
    {
        $intervals = Interval::with('book')->get();
        $mostRecommendedBooks = $this->recommendationService->getMostRecommendedBooksBasedOnHowManyUniquePagesHaveBeenRead($intervals);
        return $this->sendResponse($mostRecommendedBooks, 'Most 5 recommended books fetched successfully.');
    }

    function sendThankYouSms(User $user)
    {
        $message = "Thank you for using our service, " . $user->name . "!";
        $this->smsService->sendSms($user->phone_number, $message);
    }
}
