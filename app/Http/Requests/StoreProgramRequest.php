<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
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
            'description' => 'required|string',
            'learning_objectives' => 'required|array',
            'target_students' => 'required|integer|min:1',
            'start_date' => 'required|date|after:today',
            'industry_partners' => 'nullable|array',
            'curriculum_file' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}
