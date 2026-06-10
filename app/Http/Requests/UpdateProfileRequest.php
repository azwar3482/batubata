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
            'name' => 'nullable|string|max:255',
            'email' => 'sometimes|nullable|string|lowercase|email|max:255|unique:users,email,' . $this->user()->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'education_level' => 'nullable|string',
            'major' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'birth_date' => 'nullable|date',
            
            // Geolokasi
            'address' => 'nullable|string|max:1000',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            
            // New fields
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:100',
            'expected_jobs' => 'nullable|array',
            'expected_jobs.*.position' => 'nullable|string|max:255',
            'expected_jobs.*.salary_min' => 'nullable|numeric|min:0',
            'job_preferences' => 'nullable|string|max:1000',
            
            // Career history
            'career_histories' => 'nullable|array',
            'career_histories.*.company_name' => 'nullable|string|max:255',
            'career_histories.*.position' => 'nullable|string|max:255',
            'career_histories.*.start_date' => 'nullable|date',
            'career_histories.*.end_date' => 'nullable|date',
            'career_histories.*.is_current' => 'nullable|boolean',
            'career_histories.*.description' => 'nullable|string|max:1000',
        ];
    }
}
