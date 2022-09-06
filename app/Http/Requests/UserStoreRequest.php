<?php

namespace App\Http\Requests;


class UserStoreRequest extends BaseFormRequest
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
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:40',
            'password' => 'required'
        ];
    }
    public function messages() //special error messages
    {
        return [
            'email.unique'=> "Bu email ile daha önceden kayıt oluşturulmuştur!",
            'name.required'=> "Nmae alanı zorunludur!"
        ];
    }

}
