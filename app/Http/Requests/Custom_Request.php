<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Custom_Request extends FormRequest
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
        return ["utxt1"=>'string|nullable',
                "utxt2"=>'string|nullable',
                "utxt3"=>'string|nullable',
                "utxt4"=>'string|required',
                "pic"=>'file|image|nullable'];
    }
}
