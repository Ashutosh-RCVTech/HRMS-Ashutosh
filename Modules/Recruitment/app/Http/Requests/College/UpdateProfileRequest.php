<?php

namespace Modules\Recruitment\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:colleges,email,' . auth()->guard('college')->id()],
            'phone' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'string', 'max:20'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'contact_person_email' => ['required', 'email', 'max:255'],
            'contact_person_phone' => ['required', 'string', 'max:20'],
            'logo' => [
                'nullable',
                'file',
                'mime:image/jpeg,image/png,image/jpg,image/pjpeg',
                'max:2048',
                'dimensions:min_width=100,min_height=100'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'logo.mimetypes' => 'The logo must be a file of type: jpeg, png, jpg.',
            'logo.max' => 'The logo must not be greater than 2MB.',
            'logo.dimensions' => 'The logo must be at least 100x100 pixels.',
            'logo.file' => 'The logo must be a valid file.',
        ];
    }
}
