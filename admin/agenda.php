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

    color:white;

    padding:8px 14px;

    border-radius:20px;

    display:inline-block;

    font-weight:bold;
}

.agendado{

    background:#f59e0b;
}

.andamento{

    background:#2563eb;
}

.concluido{

    background:#22c55e;
}

.action-btn{

    color:white;

    padding:10px 16px;

    border-radius:10px;

    text-decoration:none;

    font-weight:bold;

    margin-left:15px;

    display:inline-block;
}

.start{

    background:#2563eb;
}

.finish{

    background:#16a34a;
}

.action-area{

    margin-top:20px;
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

<?= $item['os_numero']; ?>

</h2>

<p>

<strong>Cliente:</strong>

<?= $item['cliente']; ?>

</p>

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

<div class="action-area">

<?php if($item['status'] == 'Agendado') { ?>

<span class="status agendado">

Agendado

</span>

<a
href="iniciar-servico.php?id=<?= $item['id']; ?>"
class="action-btn start">

Iniciar Serviço

</a>

<?php } ?>

<?php if($item['status'] == 'Em andamento') { ?>

<span class="status andamento">

Em andamento

</span>

<a
href="finalizar-servico.php?id=<?= $item['id']; ?>"
class="action-btn finish">

Finalizar Serviço

</a>

<?php } ?>

<?php if($item['status'] == 'Concluído') { ?>

<span class="status concluido">

Concluído

</span>

<?php } ?>

</div>

</div>

<?php } ?>

</div>

</body>
</html>