<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmaciaValidator extends FormRequest
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
            'LOCALIDAD' => 'required',
            'DIRECCION' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'TELEFONO' => 'required',
            'obrasSociales' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'NOMBRE.required' => 'El campo nombre es obligatorio',
            'LOCALIDAD.required' => 'El campo localidad es obligatorio',
            'DIRECCION.required' => 'El campo direccion es obligatorio',
            'latitude.required' => 'El campo ubicacion es obligatorio',
            'longitude.required' => 'El campo ubicacion es obligatorio',
            'TELEFONO.required' => 'El campo telefono es obligatorio',
            'obrasSociales.required' => 'El campo obra social es obligatorio'
        ];
    }
}
