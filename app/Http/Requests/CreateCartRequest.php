<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCartRequest extends Request
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
            'Quantity'=>'required|numeric|min:1',
            'bookId'=>'required|numeric|min:1',
        ];
    }
}
