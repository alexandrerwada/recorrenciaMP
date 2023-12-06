<?php

require_once 'MercadoPago.php';

$produtos = [];

$mp = new MercadoPago();
$planos = $mp->obterPlanos();

foreach ($planos as $plano) {
    $produtos[] =
        [
            'nome' => $plano['reason'],
            'preco' => 'R$ ' . $plano['auto_recurring']['transaction_amount'],
            'descricao' => $plano['reason'],
            'codigo' => $plano['external_reference'],
            'checkout' => $plano['init_point'],
        ];
}
