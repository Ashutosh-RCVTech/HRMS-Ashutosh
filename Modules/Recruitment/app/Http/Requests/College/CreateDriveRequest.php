<?php

namespace Modules\Recruitment\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class CreateDriveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'venue' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            'eligibility_criteria' => 'required|array',
            'eligibility_criteria.*' => 'required|string',
            'required_documents' => 'required|array',
            'required_documents.*' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'status' => 'required|in:active,completed,cancelled',
        ];
    }
}
