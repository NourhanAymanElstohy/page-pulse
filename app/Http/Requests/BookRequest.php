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
        $rules =  [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_page' => 'required|integer|min:1',
        ];

        $book = Book::find($this->book_id);
        if ($book)
            $rules += ['end_page' => 'required|integer|min:1|gte:start_page|max:' . $book->num_of_pages];
        return $rules;
    }

    function messages()
    {
        return [
            'end_page.max' => 'The end page field must not be greater than 18 as it is the total number of pages in the book.',
        ];
    }
}
