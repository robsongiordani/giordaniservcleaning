<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/conexao.php';

$id = $_GET['id'];

$agenda = $db->querySingle("

SELECT *
FROM agenda

WHERE id = '$id'

", true);

if(!$agenda){

    die('Agenda não encontrada');

}

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone,
clientes.endereco

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '".$agenda['orcamento_id']."'

", true);

if(!$orcamento){

    die('Orçamento não encontrado');

}

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '".$agenda['orcamento_id']."'

");

while($item = $itens->fetchArray()){

    $db->exec("

    INSERT INTO historico_servicos
    (
        orcamento_id,
        cliente,
        telefone,
        endereco,
        servico,
        descricao,
        valor,
        data_execucao,
        status_pagamento
    )

    VALUES
    (
        '".$agenda['orcamento_id']."',
        '".$orcamento['nome']."',
        '".$orcamento['telefone']."',
        '".$orcamento['endereco']."',
        '".$item['servico']."',
        '".$item['descricao']."',
        '".$item['valor']."',
        '".$agenda['data']."',
        'Pendente'
    )

    ");

}

$db->exec("

UPDATE agenda

SET
    status = 'Concluído',
    valor = '".$orcamento['total']."'

WHERE id = '$id'

");

header('Location: recibos.php');

?>