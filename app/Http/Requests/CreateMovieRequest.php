<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'release_year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:'.(date('Y')+1) ],
            'director' => ['required', 'string'],
            'description' => ['string', 'max:100000'],
            'genre' => ['required', 'array'],
            'cover' => ['image', 'required']
        ];
    }
}
