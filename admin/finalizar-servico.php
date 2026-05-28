<?php

include '../config/conexao.php';

$id = $_GET['id'];

$agenda = $db->querySingle("

SELECT *
FROM agenda

WHERE id = '$id'

", true);

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '".$agenda['orcamento_id']."'

");

while($item = $itens->fetchArray()){

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
        '".$agenda['cliente']."',
        '".$agenda['telefone']."',
        '".$item['servico']."',
        '".$item['valor']."',
        '".$agenda['data']."'
    )

    ");

}

$db->exec("

UPDATE agenda

SET status = 'Concluído'

WHERE id = '$id'

");

header('Location: agenda.php');

?>