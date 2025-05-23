<?php

namespace Modules\Recruitment\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            // Add other validation rules
        ];
    }

    public function userData()
    {
        return $this->only(['name', 'email', 'password']);
    }

    public function profileData()
    {
        return $this->only([
            'phone',
            'address',
            'nationality',
            'date_of_birth',
            'skills',
            'experience_summary',
            'education'
        ]);
    }
}
