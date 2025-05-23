<?php

namespace Modules\Recruitment\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date|after:today',
            'start_time' => 'sometimes|required',
            'end_time' => 'sometimes|required|after:start_time',
            'venue' => 'sometimes|required|string|max:255',
            'max_students' => 'sometimes|required|integer|min:1',
            'eligibility_criteria' => 'sometimes|required|array',
            'eligibility_criteria.*' => 'required|string',
            'required_documents' => 'sometimes|required|array',
            'required_documents.*' => 'required|string',
            'city' => 'sometimes|required|string|max:100',
            'state' => 'sometimes|required|string|max:100',
            'country' => 'sometimes|required|string|max:100',
            'pincode' => 'sometimes|required|string|max:20',
            'status' => 'sometimes|required|in:active,completed,cancelled',
        ];
    }
}
