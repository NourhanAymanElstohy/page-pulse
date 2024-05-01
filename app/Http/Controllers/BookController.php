<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Interval;
use App\Models\User;
use App\Services\RecommendationService;
use App\Services\SMsService;
use App\Traits\RespondsWithHttpStatus;

/**
 * @OA\Info(
 *      title="PagePulse API",
 *      version="1.0.0",
 *      description="PagePulse API documentation",
 *      @OA\Contact(
 *          email="nourhanelstohy@gmail.com"
 *      ),
 * )
 */
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

    /**
     * @OA\Post(
     *     path="/api/submit-user-interval",
     *     summary="Submit user interval",
     *     tags={"Book"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BookRequest",
     *             example={"user_id": 1, "book_id": 1, "start_page": 10, "end_page": 20}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interval submitted successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Interval submitted successfully.")
     *         )
     *     )
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/api/get-most-recommended-books",
     *     summary="Get most recommended books",
     *     tags={"Book"},
     *     @OA\Response(
     *         response=200,
     *         description="Most 5 recommended books fetched successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="book_id", type="integer", example=8),
     *                     @OA\Property(property="book_name", type="string", example="Prof. Colton Pouros Jr."),
     *                     @OA\Property(property="read_pages", type="integer", example=49)
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Most 5 recommended books fetched successfully.")
     *         )
     *     )
     * )
     */
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
