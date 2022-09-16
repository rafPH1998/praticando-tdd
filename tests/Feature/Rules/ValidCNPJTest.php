<?php

namespace Tests\Feature\Rules;

use App\Rules\ValidCNPJ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ValidCNPJTest extends TestCase
{

    public function test_should_check_if_the_cpnj_is_valid_and_active()
    {
        Http::fake([
            'https://brasilapi.com.br/api/cnpj/v1/' => Http::response([
                [
                    'cpnj'                              => '47488419000106',
                    'razao_social'                      => 'Empresa teste',
                    'descricao_situacao_cadastral'      => 'ATIVO',
                ], 200]
            ),
        ]);
        
        $rule = new ValidCNPJ();

        $this->assertTrue(
            $rule->passes('cnpj', '47488419000106')
        );
    }

    public function test_should_check_if_the_cpnj_is_not_found_or_situation_inactive()
    {
        Http::fake([
            'https://brasilapi.com.br/api/cnpj/v1/' => Http::response([
                [], 404]
            ),
            'https://brasilapi.com.br/api/cnpj/v1/' => Http::response([
                [
                    'cpnj'                              => '45861022844',
                    'razao_social'                      => 'Empresa teste',
                    'descricao_situacao_cadastral' => 'INATIVO',
                ], 400]
            ),
        ]);

        $rule = new ValidCNPJ();
        
        $this->assertFalse(
            $rule->passes('cnpj', '45861022844')
        );
    }
}
