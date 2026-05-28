<?php

include '../config/conexao.php';

$id = $_GET['id'];

$db->exec("

DELETE FROM itens_orcamento

WHERE orcamento_id = '$id'

");

$db->exec("

DELETE FROM orcamentos

WHERE id = '$id'

");

header('Location: orcamentos.php');

?>