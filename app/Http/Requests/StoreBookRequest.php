<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required',
            'isbn' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Título',
            'isbn' => 'Isbn'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Campo obrigátório!'
        ];
    }
}
