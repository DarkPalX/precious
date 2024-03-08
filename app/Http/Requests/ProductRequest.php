<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'sku' => 'required|max:150',
            'name' => 'required|max:150',
            'author' => 'required|max:150',
            'book_type' => 'required',
            'file_url' => 'nullable',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required',
            'long_description' => 'nullable', 
            'reorder_point' => 'required',
            'size' => 'required',
            'weight' => 'required',
            'texture' => 'required',
            'uom' => 'required',
            'meta_title' => 'max:60',
            'meta_keyword' => 'max:160',
            'meta_description' => 'max:160',
        ];
    }
}
