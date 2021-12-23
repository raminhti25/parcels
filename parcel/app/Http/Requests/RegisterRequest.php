<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first' => 'required|string|max:50',
            'last'  => 'required|string|max:50',
            'email' => 'required|string|max:100',
            'mobile' => 'required|string|max:21',
            'password' => 'required|string|min:6:confirmed',
            'role'     => 'required|in:sender|biker'
        ];
    }
}
