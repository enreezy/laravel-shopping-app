<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => 'required|unique:items|max:255',
            'price' => 'required',
            'quantity' => 'required',
            'img_src' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'required',
            'color' => 'required',
            'category' => 'required',
            'description' => 'required'
        ];
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'name.required' => 'The Item Name is required.',
            'img_src.required' => 'The Item image is required.'
        ];
    }
}
