<?php

namespace Modules\Recruitment\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateEmploymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employments' => 'required|array',
            'employments.*.id' => 'nullable|exists:candidate_employments,id',
            'employments.*.company' => 'required|string|max:255',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.start_date' => 'required|date',
            'employments.*.end_date' => 'required_if:employments.*.current,false|nullable|date',
            'employments.*.current' => 'required|boolean',
            'employments.*.description' => 'required|string',
        ];
    }
}
