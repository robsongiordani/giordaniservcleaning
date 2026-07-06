<?php

include '../config/conexao.php';

$id = (int)$_GET['id'];

/*
Buscar o número da OS para apagar tudo relacionado
*/

$orcamento = $db->querySingle("
SELECT *
FROM orcamentos
WHERE id = $id
", true);

if(!$orcamento){

    header("Location: orcamentos.php");
    exit;

}

/*
Apaga histórico (Recibos, Financeiro, Produção e Comissões)
*/

$db->exec("

DELETE FROM historico_servicos

WHERE orcamento_id = $id

");

/*
Apaga Agenda
*/

$db->exec("

DELETE FROM agenda

WHERE orcamento_id = $id

");

/*
Apaga Itens do orçamento
*/

$db->exec("

DELETE FROM itens_orcamento

WHERE orcamento_id = $id

");

/*
Apaga o orçamento
*/

$db->exec("

DELETE FROM orcamentos

WHERE id = $id

");

header("Location: orcamentos.php");
exit;

?>