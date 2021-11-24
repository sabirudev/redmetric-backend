<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageUpdate extends FormRequest
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
            'name' => 'required|string|unique:villages,name,' . $this->village->id . ',id',
            'head' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'website' => 'string',
            'province' => 'sometimes|required|string',
            'amount_productive_age' => 'required|numeric',
            'area' => 'required|numeric',
        ];
    }
}
