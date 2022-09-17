<?php

namespace App\Http\Requests;

use App\Rules\ValidCNPJ;
use Illuminate\Foundation\Http\FormRequest;

class TesteRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cnpj' => ['required', 'unique:books', 'max:14', new ValidCNPJ],
        ];
    }

    public function attributes()
    {
        return [
            'required' => 'obrigatório',
            'max'      => 'máximo',
        ];
    }


    public function messages()
    {
        return [
            'required'     => 'O campo :attribute é obrigatório!',
            'max'          => 'O campo :attribute deve conter apenas 14 caracteres! Digite o CNPJ sem pontos ou traços para ser válido.',
            'unique'       => 'O campo :attribute já está cadastrado em nossa base!',
        ];
    }
}
