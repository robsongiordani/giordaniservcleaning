<?php

include '../config/conexao.php';

$id = (int)$_GET['id'];

$agenda = $db->querySingle("
SELECT *
FROM agenda
WHERE id = $id
", true);

if(!$agenda){

    die("Ordem de Serviço não encontrada.");

}

$orcamento_id = (int)$agenda['orcamento_id'];

/*
Apaga histórico (Recibos, Financeiro, Produção e Comissões)
*/

$db->exec("
DELETE FROM historico_servicos
WHERE orcamento_id = $orcamento_id
");

/*
Apaga histórico financeiro
*/

$db->exec("
DELETE FROM historico_financeiro
WHERE orcamento_id = $orcamento_id
");

/*
Apaga serviços executados
*/

$db->exec("
DELETE FROM servicos_executados
WHERE orcamento_id = $orcamento_id
");

/*
Apaga agenda
*/

$db->exec("
DELETE FROM agenda
WHERE id = $id
");

header("Location: agenda.php");
exit;

?>