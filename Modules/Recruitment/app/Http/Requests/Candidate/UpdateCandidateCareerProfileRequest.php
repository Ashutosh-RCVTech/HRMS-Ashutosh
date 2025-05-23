<?php

namespace Modules\Recruitment\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateCareerProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_industry' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'desired_job_type' => 'required|string|max:255',
            'desired_employment_type' => 'required|string|max:255',
            'preferred_shift' => 'required|string|max:255',
            'preferred_work_location' => 'required|string|max:255',
            'expected_salary' => 'required|numeric',
        ];
    }
}
