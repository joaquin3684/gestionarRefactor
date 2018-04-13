<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidator extends FormRequest
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
            'name' => 'required|unique:Usuarios,name,'.$this->get('id'),
            'password' => 'required',
            'email' => 'required',
            'id_perfil' => 'required',
            'obrasSociales' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'name.unique' => 'El campo nombre ya existe',
            'password.required' => 'El campo contraseña es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'perfil.required' => 'El campo perfil es obligatorio',
            'obrasSociales.required' => 'El campo obras sociales es obligatorio',
        ];
    }
}
