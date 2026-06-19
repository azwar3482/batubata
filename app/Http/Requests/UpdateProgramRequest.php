<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'duration' => 'required|string',
            'description' => 'required|string|max:5000',
            'learning_objectives' => 'required|array',
            'learning_objectives.*' => 'required|string|max:5000',
            'target_students' => 'required|integer|min:1|max:500',
            'start_date' => 'required|date',
            'status' => 'required|string|in:active,upcoming,completed',
            'industry_partners' => 'nullable|array',
            'curriculum_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
