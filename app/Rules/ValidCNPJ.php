<?php

namespace App\Rules;

use App\Services\BrasilAPI\Enum\CNPJSituacaoCadastral;
use App\Services\BrasilAPI\BrasilAPI;
use Illuminate\Contracts\Validation\Rule;
use App\Services\BrasilAPI\Exceptions\CPNJNotFound;

class ValidCNPJ implements Rule
{

    public function passes($attribute, $value)
    {
        
        try {
            $cpnj = (new BrasilAPI)->cpnj($value);

            return $cpnj->descricaoSituacaoCadastral == CNPJSituacaoCadastral::ATIVO;

        } catch (CPNJNotFound $error) {
            return false;
        }
    }

    public function message()
    {
        return 'CNPJ inexistente!';
    }
}
