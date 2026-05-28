<?php

include '../config/conexao.php';

$id = $_GET['id'];

$db->exec("

UPDATE agenda

SET status = 'Em andamento'

WHERE id = '$id'

");

header('Location: agenda.php');

?>