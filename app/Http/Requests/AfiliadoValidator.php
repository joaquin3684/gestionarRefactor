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
            'DNI' => 'required|unique:afiliados,DNI,'.$this->get('ID'),
            'NOMBRE' => 'required',
            'APELLIDO' => 'required',
            'EMAIL' => 'required',
            'TELEFONO' => 'required',
            'CELULAR' => 'required',
            'DIRECCION' => 'required',
            'NACIMIENTO' => 'required',
            'CUIL' => 'required',
            'IDOBRASOCIAL' => 'required',
        ];
    }
}
