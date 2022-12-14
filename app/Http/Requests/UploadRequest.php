<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'uploadFile'=>'required|image|mimes:jpg,png|max:10240'
        ];
    }
    public function messages() //special error messages
    {
        return [
            'uploadFile.required'=> "Please upload a photo!",
            'uploadFile.max'=> "File size cannot be larger than 10mb!"
        ];
    }
}
