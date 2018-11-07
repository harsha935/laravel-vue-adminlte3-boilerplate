<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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

    public function rules()
    {
        return [
            'item_name' => 'required|min:5',
            'item_code' => 'required|digits:4',
            'item_price' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
    }
}
