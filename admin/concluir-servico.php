<?php

include '../config/conexao.php';

$id = $_GET['id'];

$servico = $db->querySingle("

SELECT *
FROM agenda

WHERE id = '$id'

", true);

$valor = 0;

preg_match('/R\$ ?([0-9,.]+)/', $servico['servicos'], $match);

if(isset($match[1])){

    $valor = str_replace(',', '.', str_replace('.', '', $match[1]));
}

$db->exec("

INSERT INTO historico_financeiro
(
    cliente,
    telefone,
    servico,
    valor,
    data
)

VALUES
(
    '".$servico['cliente']."',
    '".$servico['telefone']."',
    '".$servico['servicos']."',
    '$valor',
    '".$servico['data']."'
)

");

$db->exec("

UPDATE agenda

SET status = 'Concluído'

WHERE id = '$id'

");

header('Location: agenda.php');

?>