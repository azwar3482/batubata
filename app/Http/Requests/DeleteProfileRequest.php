<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends FormRequest
{
    /**
     * Nama error bag untuk disesuaikan dengan frontend bawaan Breeze (userDeletion).
     */
    protected $errorBag = 'userDeletion';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }
}
