<?php

namespace Tests\Feature;

use App\Enums\Tipo;
use Faker\Provider\Lorem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_entry()
    {

        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Compra de Ocitocina',
            'tipo' => Tipo::SAIDA->value,
            'valor' => 100.00,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'id' => 1,
                'data' => now()->format('d/m/Y'),
                'descricao' => 'Compra de Ocitocina',
                'tipo' => 'saida',
                'valor' => 'R$ 100,00'
            ]);
    }
    public function test_store_validation_date_error()
    {
        // Formato de data inválido
        $response = $this->postJson('api/entry', [
            'data' => now()->format('Y-m-d'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 200.0,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A data deve estar no formato DD/MM/AAAA.',
                'code' => 422,
            ]);



        // Data vazia
        $response = $this->postJson('api/entry', [
            'data' => '',
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 200,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O campo data é obrigatório.',
                'code' => 422,
            ]);
    }

    public function test_store_validation_descricao_error()
    {

        // Descrição vazia
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => '',
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 300,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A descrição é obrigatória.',
                'code' => 422,
            ]);


        // Descrição não é um texto válido
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 1234,
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 300,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A descrição deve ser um texto.',
                'code' => 422,
            ]);

        //Descrição excede o tamanho máximo permitido de caracteres
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'dwadawdawdwadadaw dwadawdwada A descrição não pode ter mais de 255 caracteres. A descrição não pode ter mais de 255 caracteres.A descrição não pode ter mais de 255 caracteres.A descrição não pode ter mais de 255 caracteres.A descrição não pode ter mais de 255 caracteres.',
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 300,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A descrição não pode ter mais de 255 caracteres.',
                'code' => 422,
            ]);


        // Descrição não atinge o mínimo de caracteres
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'O',
            'tipo' => Tipo::ENTRADA->value,
            'valor' => 300,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A descrição deve ter pelo menos 2 caracteres.',
                'code' => 422,
            ]);
    }

    public function test_store_validation_tipo_error()
    {

        //Tipo vazio
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => '',
            'valor' => 100,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O tipo é obrigatório.',
                'code' => 422,
            ]);

        // Tipo não incluso nos valores válidos(entrada/saída)
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => 'invalid value',
            'valor' => 100,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O tipo deve ser "entrada" ou "saida".',
                'code' => 422
            ]);
    }


    public function test_store_entry_valor_error()
    {
        // Valor vazio
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::SAIDA->value,
            'valor' => '',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O valor é obrigatório.',
                'code' => 422
            ]);


        //Valor não é um número
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::SAIDA->value,
            'valor' => 'Invalid value',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O valor deve ser um número. (and 1 more error)',
                'code' => 422,
            ]);

        //O valor deve ser maior que zero.
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::SAIDA->value,
            'valor' => -10,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O valor deve ser maior que zero. (and 1 more error)',
                'code' => 422
            ]);


        // O valor pode ter no máximo duas casas decimais.
        $response = $this->postJson('api/entry', [
            'data' => now()->format('d/m/Y'),
            'descricao' => 'Lorem ipsum dollor',
            'tipo' => Tipo::SAIDA->value,
            'valor' => 200.001,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O valor pode ter no máximo duas casas decimais.',
                'code' => 422,
            ]);
    }
}
