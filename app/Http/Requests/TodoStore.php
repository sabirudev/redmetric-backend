<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoStore extends FormRequest
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
            'submission_id' => 'required|exists:submissions,id',
            'submissions' => 'required|array',
            'submissions.*.indicator_submission_id' => 'exists:indicator_submission,id',
            'submissions.*.point' => 'in:1,2,3,4,5'
        ];
    }
}
