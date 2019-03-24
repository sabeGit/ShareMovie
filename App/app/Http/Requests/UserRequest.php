<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'uploadedImage' => 'required|between:1,560',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'コメントを入力してください',
            'content.between' => 'コメントは560文字以内で入力してください',
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
