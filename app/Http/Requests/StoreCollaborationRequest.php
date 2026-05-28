<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollaborationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'partner_id' => 'required|exists:partners,id',
            'collaboration_type' => 'required|array',
            'collaboration_type.*' => 'string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'expected_outcome' => 'required|string',
            'timeline' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
