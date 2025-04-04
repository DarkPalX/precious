<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerAdRequest extends FormRequest
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
            'name' => 'required',
            'file_url' => 'nullable',
            'mobile_file_url' => 'nullable',
            'url' => 'nullable',
            'pages' => 'required',
            'expiration_date' => 'required',
            'is_mobile' => 'nullable',
            'status' => 'nullable',
        ];
    }
}
