<?php

namespace Modules\Recruitment\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $candidateId = $this->method() === 'PUT' ? $this->route('candidate') : null;
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidate_users,email,' . $candidateId,
            'password' => $this->isMethod('PUT') ? 'nullable|min:6' : 'required|min:6',

            'basic_detail.name' => 'required|string|max:255',
            'basic_detail.location' => 'required|string|max:255',
            'basic_detail.mobile' => 'required|string|max:20',
            'basic_detail.mobile_verified' => 'boolean',
            'basic_detail.availability' => 'nullable|date',
            'basic_detail.resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'basic_detail.profile_image' => 'nullable|image|max:2048',
            'basic_detail.resume_headline' => 'nullable|string|max:255',
            'basic_detail.key_skills' => 'nullable|string',
            'basic_detail.it_skills' => 'nullable|array',
            'basic_detail.it_skills.*' => 'string|max:50',
            'basic_detail.projects' => 'nullable|string',
            'basic_detail.profile_summary' => 'nullable|string',

            'educations' => 'nullable|array',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'educations.*.grade' => 'nullable|string|max:50',

            'employments' => 'nullable|array',
            'employments.*.company' => 'required|string|max:255',
            'employments.*.position' => 'required|string|max:255',
            'employments.*.start_date' => 'required|date',
            'employments.*.end_date' => 'nullable|date|after:employments.*.start_date',
            'employments.*.current' => 'boolean',
            'employments.*.description' => 'nullable|string',

            'career_profile.current_industry' => 'required|string|max:255',
            'career_profile.department' => 'required|string|max:255',
            'career_profile.desired_job_type' => 'required|string|max:255',
            'career_profile.desired_employment_type' => 'required|string|max:255',
            'career_profile.preferred_shift' => 'required|string|max:255',
            'career_profile.preferred_work_location' => 'required|string|max:255',
            'career_profile.expected_salary' => 'required|numeric|min:0',
        ];

        return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'basic_detail.resume.max' => 'The resume must not be greater than 5MB.',
    //         'basic_detail.profile_image.max' => 'The profile image must not be greater than 2MB.',
    //         'basic_detail.key_skills.*.max' => 'Each skill must not exceed 50 characters.',
    //         'employments.*.end_date.after' => 'The end date must be after the start date.',
    //     ];
    // }


    // public function rules()
    // {
    //     $candidateId = $this->method() === 'PUT' ? $this->route('id') : null;

    //     return [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:candidate_users,email,' . $candidateId,
    //         'password' => $candidateId ? 'nullable|min:6' : 'required|min:6',

    //         'basic_detail.location' => 'required|string|max:255',
    //         'basic_detail.mobile' => 'required|string|max:20',
    //         'basic_detail.availability' => 'nullable|date',
    //         'basic_detail.resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    //         'basic_detail.profile_image' => 'nullable|image|max:2048',
    //         'basic_detail.resume_headline' => 'nullable|string|max:255',
    //         'basic_detail.key_skills' => 'nullable|string',

    //         'educations' => 'nullable|array',
    //         'educations.*.degree' => 'required|string|max:255',
    //         'educations.*.institution' => 'required|string|max:255',
    //         'educations.*.year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
    //         'educations.*.grade' => 'nullable|string|max:50',

    //         'employments' => 'nullable|array',
    //         'employments.*.company' => 'required|string|max:255',
    //         'employments.*.position' => 'required|string|max:255',
    //         'employments.*.start_date' => 'required|date',

    //         'employments.*.end_date' => 'nullable|date|after:employments.*.start_date',

    //         'career_profile.current_industry' => 'required|string|max:255',
    //         'career_profile.department' => 'required|string|max:255',
    //         'career_profile.desired_job_type' => 'required|string|max:255',
    //         'career_profile.expected_salary' => 'required|numeric|min:0',
    //     ];
    // }

    public function messages()
    {
        return [
            'basic_detail.resume.max' => 'The resume must not be greater than 5MB.',
            'basic_detail.profile_image.max' => 'The profile image must not be greater than 2MB.',
            'educations.*.degree.required' => 'Degree is required for each education entry.',
            'educations.*.institution.required' => 'Institution is required for each education entry.',
            'employments.*.company.required' => 'Company is required for each employment entry.',
            'employments.*.position.required' => 'Position is required for each employment entry.',
            'employments.*.end_date.after' => 'The end date must be after the start date.',
        ];
    }
}
