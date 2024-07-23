<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdatePasswordRequest extends FormRequest
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
        $id = $this->user()->id;
        return [
            'current_password' => 'required|string',
            'password_new' => 'required|confirmed|nullable|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

    public function messages()
    {
        return [
            'password_new.regex' => 'password must Contain at least one uppercase/lowercase letters, one number and one special char'
        ];
    }
}
