<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('id'),
            'status' => 'required|in:active,inactive,invited',
            'role' => 'required|in:staf_hr_manager,staf_recruiter,staf_talent_sourcer,staf_interviewer',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ];
    }
}
