<?php

include '../config/conexao.php';

$id=(int)$_POST['id'];

$comissao=(float)$_POST['comissao'];

$registro=$db->querySingle("

SELECT valor

FROM historico_servicos

WHERE id=$id

",true);

$lucro=$registro['valor']-$comissao;

$db->exec("

UPDATE historico_servicos

SET

comissao=$comissao,

lucro=$lucro

WHERE id=$id

");

header("Location: financeiro.php");

exit;

?>