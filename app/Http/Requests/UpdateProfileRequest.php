<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $this->user()->id,
            'phone' => 'nullable|string|max:20',
            'education_level' => 'required|string',
            'major' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'birth_date' => 'nullable|date',
            
            // New fields
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:100',
            'expected_job_type' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'job_preferences' => 'nullable|string|max:1000',
            
            // Career history
            'career_histories' => 'nullable|array',
            'career_histories.*.company_name' => 'required_with:career_histories|string|max:255',
            'career_histories.*.position' => 'required_with:career_histories|string|max:255',
            'career_histories.*.start_date' => 'required_with:career_histories|date',
            'career_histories.*.end_date' => 'nullable|date|after_or_equal:career_histories.*.start_date',
            'career_histories.*.is_current' => 'nullable|boolean',
            'career_histories.*.description' => 'nullable|string|max:1000',
        ];
    }
}
