<?php

namespace App\Http\Requests;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SubmissionStore extends FormRequest
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
        Validator::extend('valid_period', function ($field, $value) {
            $result = Period::where('id', $value)
                ->whereDate('opened', '<=', Carbon::now()->format('Y-m-d'))
                ->whereDate('closed', '>=', Carbon::now()->format('Y-m-d'))
                ->where('is_ended', false)
                ->first();
            return $result;
        });
        return [
            'period_id' => 'required|exists:periods,id|valid_period',
            'submissions' => 'required|array',
            'submissions.*.indicator_id' => 'required|exists:indicators,id',
            'submissions.*.indicator_input_id' => 'required|exists:indicator_inputs,id',
            'submissions.*.value' => 'nullable|numeric',
            'code' => 'sometimes|exists:indicators,code',
            'page' => 'sometimes|exists:indicator_criterias,id'
        ];
    }

    public function messages()
    {
        return [
            'period_id.valid_period' => 'Mohon Maaf Period Pemeringkatan sudah ditutup'
        ];
    }
}
