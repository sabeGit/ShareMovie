<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
        return [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは6文字以上で入力してください',
            'password.confirmed' => 'パスワードが異なります',
            'password_confirmation.required' => 'パスワード（確認）を入力してください',
        ];
    }

    protected function failedValidation( Validator $validator )
    {
        $response['messages']  = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json( $response, 400 )
        );
    }
}
