<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageStore extends FormRequest
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
            'name' => 'required|unique:villages,name|string',
            'head' => 'required|string',
            'address' => 'required|string',
            'website' => 'string',
            'province' => 'required|string',
            'amount_productive_age' => 'required|numeric',
            'area' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'head.required' => 'Kepala Desa/Lurah wajib diisi',
            'head.string' => 'Kepala Desa/Lurah tidak mengandung nomor atau angka',
        ];
    }
}
