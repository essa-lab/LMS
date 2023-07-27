<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ResetPassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  Gate::check('sanctum-authenticated');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //

            'password'=>['required','string','min:8','regex:/[!@#$%^&*]/'],
            'new_password'=>['required','string','min:8','regex:/[!@#$%^&*]/','confirmed']
        ];
    }
    public function messages()
    {
        return[
            'password.required'=>'The password field is required',
            'password.min'=>'Password must be longer than 8 char',
            'password.regex'=>'Password must include special char(!@#$%^&*)',
            'new_password.required'=>'The password field is required',
            'new_password.min'=>'Password must be longer than 8 char',
            'new_password.regex'=>'Password must include special char(!@#$%^&*)'
        ];
    }
}
