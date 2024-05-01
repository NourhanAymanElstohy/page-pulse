<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

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
