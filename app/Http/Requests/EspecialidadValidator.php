<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EspecialidadValidator extends FormRequest
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
            'NOMBRE' => [
                'required',
                Rule::unique('Especialidad')->ignore($this->get('IDESPECIALIDAD'), 'IDESPECIALIDAD'),
            ],
            'ESTUDIO' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ESTUDIO.required' => 'El campo estudio es obligatorio',
            'NOMBRE.unique' => 'El campo nombre debe ser unico',
            'NOMBRE.required' => 'El campo nombre es obligatorio',
        ];
    }
}
