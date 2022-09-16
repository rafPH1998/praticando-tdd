<?php

namespace App\Services\BrasilAPI\Enum;

enum CNPJSituacaoCadastral: string
{
    case ATIVO = 'ATIVA';
    case INATIVO = 'INATIVO';
}