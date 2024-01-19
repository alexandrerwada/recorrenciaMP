<?php

require_once 'MercadoPago.php';

$produtos = [];

$mp = new MercadoPago();
$planos = $mp->obterPlanos();

foreach ($planos as $plano) {
    $produtos[] =
        [   
            'id_plano' => $plano['id'],
            'nome' => $plano['reason'],
            'preco' => 'R$ ' . $plano['auto_recurring']['transaction_amount'],
            'preco_sem_formatacao' => $plano['auto_recurring']['transaction_amount'],
            'descricao' => $plano['reason'],
            'codigo' => $plano['external_reference'],
            'checkout' => $plano['init_point'],
        ];
}
