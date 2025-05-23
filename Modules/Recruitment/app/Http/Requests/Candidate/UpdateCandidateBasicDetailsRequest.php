<?php

namespace Modules\Recruitment\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateBasicDetailsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'regex:/^\+\d{1,4}\d{6,14}$/' // Allows country code + national number
            ],
            'resume_headline' => 'required|string|max:255',
            'key_skills' => 'required|array',
            'it_skills' => 'required|array',
            'profile_summary' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'mobile.regex' => 'Please enter a valid mobile number with country code (e.g., +91XXXXXXXXXX).',
        ];
    }
}
