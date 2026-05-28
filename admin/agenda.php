<?php

include '../config/conexao.php';

$agenda = $db->query("

SELECT *
FROM agenda

ORDER BY data ASC

");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Agenda</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.agenda-card{

    background:white;

    padding:25px;

    border-radius:20px;

    margin-bottom:20px;
}

.agenda-card h2{

    color:#1e3a8a;

    margin-bottom:15px;
}

.agenda-card p{

    margin:8px 0;

    color:#334155;
}

.status{

    background:#22c55e;

    color:white;

    padding:8px 14px;

    border-radius:20px;

    display:inline-block;

    margin-top:10px;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Agenda de Serviços</h1>

</div>

<?php while($item = $agenda->fetchArray()) { ?>

<div class="agenda-card">

<h2>

<?= $item['cliente']; ?>

</h2>

<p>

<strong>Telefone:</strong>

<?= $item['telefone']; ?>

</p>

<p>

<strong>Serviços:</strong>

<?= $item['servicos']; ?>

</p>

<p>

<strong>Data:</strong>

<?= $item['data']; ?>

</p>

<p>

<strong>Horário:</strong>

<?= $item['horario']; ?>

</p>

<p>

<strong>Observações:</strong>

<?= $item['observacoes']; ?>

</p>

<div class="status">

<?= $item['status']; ?>

</div>

</div>

<?php } ?>

</div>

</body>
</html>