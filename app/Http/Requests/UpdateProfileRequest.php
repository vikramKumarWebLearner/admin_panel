<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'sometimes|required|max:255|unique:users,email,' . $id,
            'password_new' => 'sometimes|nullable|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ];
    }

    public function messages()
    {
        return [
            'password_new.regex' => 'password must Contain at least one uppercase/lowercase letters, one number and one special char'
        ];
    }
}
