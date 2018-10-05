<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AfiliadoValidator extends FormRequest
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
            'DNI' => 'required|unique:Afiliados,DNI,'.$this->get('ID'),
            'NOMBRE' => 'required',
            'APELLIDO' => 'required',
            'TELEFONO' => 'required',
            'CELULAR' => 'required',
            'DIRECCION' => 'required',
            'NACIMIENTO' => 'required',
            'NAFILIADO' => 'required|unique:Afiliados,NAFILIADO,'.$this->get('ID'),
            'CUIL' => 'required|unique:Afiliados,CUIL,'.$this->get('ID'),
            'IDOBRASOCIAL' => 'required',
            'PLAN' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'DNI.required' => 'El campo dni es obligatorio',
            'DNI.unique' => 'El campo dni debe ser unico',
            'NOMBRE.required' => 'El campo nombre es obligatorio',
            'APELLIDO.required' => 'El campo apellido es obligatorio',
            'TELEFONO.required' => 'El campo telefono es obligatorio',
            'CELULAR.required' => 'El campo celular es obligatorio',
            'DIRECCION.required' => 'El campo direccion es obligatorio',
            'NACIMIENTO.required' => 'El campo nacimiento es obligatorio',
            'NAFILIADO.required' => 'El campo nro afiliado es obligatorio',
            'NAFILIADO.unique' => 'El campo nro afiliado debe ser unico',
            'CUIL.required' => 'El campo cuil es obligatorio',
            'CUIL.unique' => 'El campo cuil debe ser unico',
            'IDOBRASOCIAL.required' => 'El campo obra social es obligatorio',
            ];
    }
}
