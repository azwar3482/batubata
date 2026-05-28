<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteTeamMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:staf_hr_manager,staf_recruiter,staf_talent_sourcer,staf_interviewer',
            'message' => 'nullable|string|max:500',
        ];
    }
}
