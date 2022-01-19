<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordRules = [
            'required',
            'min:8',
            'max:32',
        ];
        return [
            'currentPassword' => $passwordRules,
            'newPassword' => $passwordRules,
            'confirmPassword' => array_merge($passwordRules, ['same:newPassword']),
        ];
    }
}
