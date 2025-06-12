<?php

namespace App\Http\Requests;

use App\Enums\Tipo;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntryRequest extends FormRequest
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
            'data' => ['required', 'date_format:d/m/Y'],
            'descricao' => ['required', 'string', 'max:255', 'min:2'],
            'tipo' => ['required', 'in:' . implode(',', Tipo::values())],
            'valor' => ['required', 'numeric', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }

    public function messages(): array
    {
        return [
            'data.required' => 'O campo data é obrigatório.',
            'data.date_format' => 'A data deve estar no formato DD/MM/AAAA.',

            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode ter mais de 255 caracteres.',
            'descricao.min' => 'A descrição deve ter pelo menos 2 caracteres.',

            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser "entrada" ou "saida".',

            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'valor.regex' => 'O valor pode ter no máximo duas casas decimais.',
        ];
    }
}
