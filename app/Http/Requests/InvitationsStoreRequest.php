<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvitationsStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The invited users must have a Birdboard account.'
        ];
    }
}
