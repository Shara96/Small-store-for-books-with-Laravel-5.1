<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAuthorsRequest extends Request
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
     *  |regex:/^[a-zA-Z ]+$'
     * @return array
     */
    public function rules()
    {
        return [
            'author_name'=>'required|min:4',
        ];
    }
}
