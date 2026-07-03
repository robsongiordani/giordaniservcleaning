<?php

include '../config/conexao.php';

$agenda_id = (int)$_POST['agenda_id'];
$funcionario_id = (int)$_POST['funcionario_id'];

$funcionario = $db->querySingle("
SELECT nome
FROM funcionarios
WHERE id = $funcionario_id
");

$db->exec("

UPDATE agenda

SET

funcionario_id = $funcionario_id,

funcionario_nome = '$funcionario'

WHERE id = $agenda_id

");

header("Location: agenda.php");
exit;