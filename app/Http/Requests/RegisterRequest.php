<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $acceptHeader = $this->headers->get('accept');

        return $acceptHeader === 'application/json';
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
            'name'=>['required','string',Rule::unique('users')],
            'email'=>['required','email',Rule::unique('users')],
            'password'=>['required','string','min:8','regex:/[!@#$%^&*]/','confirmed']
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'Name Field is required',
            'name.unique'=>'name is taken',
            'email.email'=>'Please make sure you entered valid email',
            'email.required'=>'The email field is required',
            'email.unique'=>'This email is taken',
            'password.required'=>'The password field is required',
            'password.min'=>'Password must be longer than 8 char',
            'password.regex'=>'Password must include special char(!@#$%^&*)'
        ];
    }
}
