<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FrontRequest extends Request
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
            'txtNumCaso' => 'required|Numeric',
            'txtMatriz' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'txtNumCaso.required' => 'Es necesario ingresar el Nro de casos',
            'txtNumCaso.numeric' => 'Nro de casos debe ser n&uacute;merico',
            'txtMatriz.required' => 'Es necesario ingresar la matriz y ejecución',
        ];
    }

}
