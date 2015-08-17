<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateBookRequest extends Request
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
            'book_title'=>'required|min:3|regex:/^[a-zA-Z0-9 #.]+$/',
            'url'=>'required|regex:/^[www.][a-zA-z0-9 \/&@+#%?=~_\!:,.-]*[-a-z0-9+&@#\/%=~_-]+$/',
            'image'=>'required|image',
            'price'=>'required|numeric|min:0.1', // numeric|min:0.1
            'description'=>'required|min:45', // |regex:/^[a-zA-Z0-9?$@#()\'!,+\-=_:.&€£*%\s "]+$/',
            'categories'=>'required|array',
            'authors'=>'required|array',


        ];
     /**   $messages = [
            'unique' => 'The :attribute already been registered.',
            'phone.regex' => 'The :attribute number is invalid , accepted format: xxx-xxx-xxxx',
            'address.regex' => 'The :attribute format is invalid.',
        ];
      */
    }
}
