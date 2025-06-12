<?php

namespace App\Http\Requests;

use App\Enums\Tipo;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => ['sometimes', 'date_format:d/m/Y'],
            'descricao' => ['sometimes', 'string', 'max:255', 'min:2'],
            'tipo' => ['sometimes', 'in:' . implode(',', Tipo::Values())],
            'valor' => ['sometimes', 'numeric', 'min: 0.01', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }
    public function messages(): array
    {
        return [
            'data.date_format' => 'A data deve estar no formato DD/MM/YYYY.',

            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'descricao.min' => 'A descrição deve ter pelo menos 2 caracteres.',

            'tipo.in' => 'O tipo deve ser "entrada" ou "saida".',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'valor.regex' => 'O valor pode ter no máximo duas casas decimais.',
        ];
    }
}
