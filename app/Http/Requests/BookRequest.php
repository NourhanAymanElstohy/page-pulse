<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="BookRequest",
 *     required={"user_id", "book_id", "start_page", "end_page"},
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user"
 *     ),
 *     @OA\Property(
 *         property="book_id",
 *         type="integer",
 *         description="The ID of the book"
 *     ),
 *     @OA\Property(
 *         property="start_page",
 *         type="integer",
 *         description="The start page of the interval"
 *     ),
 *     @OA\Property(
 *         property="end_page",
 *         type="integer",
 *         description="The end page of the interval"
 *     ),
 * )
 */
class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_page' => 'required|integer|min:1',
            'end_page' => ['required', 'integer', 'min:1', 'gte:start_page', function ($attribute, $value, $fail) {
                $book = Book::find($this->book_id);
                if ($book && $value > $book->num_of_pages) {
                    $fail('The ' . $attribute . ' must be less than or equal to ' . $book->num_of_pages . '.');
                }
            }]
        ];
    }
}
