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
            'status' => 'required',
            'currency_id' => 'required|numeric',
            'expiration' => 'date_format:Y-m-d'
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
            'status.required' => 'No has seleccionado un estado',
            'currency_id.required' => 'No has seleccionado una moneda',
            'currency_id.numeric' => 'No has seleccionado una moneda',
            'expiration.date_format' => 'No has seleccionado una fecha válida'
        ];
    }
}
