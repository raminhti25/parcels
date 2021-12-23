<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateParcelRequest extends FormRequest
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
            'pick_up_address'   => 'required|max:255',
            'drop_off_address'  => 'required|max:255',
            'recipient_mobile'  => 'required|max:21',
            'details'           => 'array',
        ];
    }
}
