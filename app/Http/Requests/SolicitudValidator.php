<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudValidator extends FormRequest
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
            'DNISOLICITANTE' => 'required',
            'IDAFILIADO' => 'required',
            'IDCLIMED' => 'required',
            'ESPECIALIDAD' => 'required',

        ];
    }
}
