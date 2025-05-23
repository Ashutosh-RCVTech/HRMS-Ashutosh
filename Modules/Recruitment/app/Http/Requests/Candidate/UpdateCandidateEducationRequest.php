<?php

namespace Modules\Recruitment\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateEducationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Assuming authorization is handled by middleware
    }

    public function rules()
    {
        return [
            'educations' => 'required|array',
            'educations.*.id' => 'nullable|exists:candidate_educations,id',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year' => 'required|integer',
            'educations.*.grade' => 'required|string|max:50',
            'educations.*.college_id' => 'nullable|exists:colleges,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($this->input('educations', []) as $index => $education) {
                $collegeId = $education['college_id'] ?? null;
                $institution = $education['institution'] ?? null;
                // If both are empty, error
                if (empty($collegeId) && (empty($institution) || trim($institution) === '')) {
                    $validator->errors()->add("educations.$index.college_id", 'Please select a college or enter a new one.');
                }
            }
        });
    }
}
