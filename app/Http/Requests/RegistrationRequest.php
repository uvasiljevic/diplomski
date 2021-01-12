<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            "r_firstname"    => "required|regex:/^[\pL\s\-]+$/u",
            "r_lastname"     => "required|regex:/^[\pL\s\-]+$/u",
            'r_email'        => 'required|unique:uv_user,email|email',
            "r_phone"        => "required|alpha_dash",
            "r_city"         => "required|regex:/^[\pL\s\-]+$/u",
            "r_zip"          => "required|numeric",
            "r_street"       => "required|regex:/^[\pL\s\-]+$/u",
            "r_streetNumber" => "required|numeric",
            "r_password"     => "required|min:6|confirmed",
        ];
    }
}
