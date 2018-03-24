<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecomendacionValidator extends FormRequest
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
            'NOMBRE' => 'required',
            'APELLIDO' => 'required',
            'NRO' => 'required',
            'FECHA' => 'required',
            'CONTACTADO' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'NOMBRE.required' => 'El campo nombre es obligatorio',
            'APELLIDO.required' => 'El campo apellido es obligatorio',
            'NRO.required' => 'El campo nro es obligatorio',
            'FECHA.required' => 'El campo fecha es obligatorio',
            'CONTACTADO.required' => 'El campo contactado es obligatorio',
        ];
    }
}
