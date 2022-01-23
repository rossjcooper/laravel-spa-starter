<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->user->id;
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'name' => [
                'required',
                'max:100',
            ],
            'password' => [
                'nullable',
                'min:8',
                'max:32',
            ],
        ];
    }
}
