<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest
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
            'currency_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'expiration' => 'date_format:Y-m-d',
            'status' => 'required',
            'client_id' => 'required',
            'company' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'estimate_details' => 'required'
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currency_id.required' => 'No has seleccionado una moneda',
            'currency_id.numeric' => 'No has seleccionado una moneda',
            'expiration.date_format' => 'No has seleccionado una fecha válida',
            'status.required' => 'No has seleccionado un estado',
            'client_id.required' => 'No has seleccionado un cliente',
            'company.required' => 'No has escrito una empresa',
            'phone.required' => 'No has escrito un teléfono de contacto',
            'email.required' => 'No has escrito un correo electrónico',
            'email.email' => 'No has escrito un correo electrónico válido',
            'estimate_details.required' => 'No has seleccionado ningún producto'
        ];
    }
}
