<?php

include '../config/conexao.php';

$funcionario = $_GET['funcionario'] ?? '';

$inicio = $_GET['inicio'] ?? date('Y-m-01');
$fim = $_GET['fim'] ?? date('Y-m-t');

$dados = $db->query("

SELECT *

FROM historico_servicos

WHERE funcionario_nome = '$funcionario'

AND date(data_execucao)

BETWEEN '$inicio' AND '$fim'

ORDER BY data_execucao DESC

");

$resumo = $db->querySingle("

SELECT

COUNT(*) as quantidade,

SUM(valor) as faturamento,

SUM(comissao) as comissao

FROM historico_servicos

WHERE funcionario_nome = '$funcionario'

AND date(data_execucao)

BETWEEN '$inicio' AND '$fim'

", true);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Produção do Funcionário</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.box{

background:white;

padding:25px;

border-radius:20px;

margin-bottom:20px;

}

table{

width:100%;

border-collapse:collapse;

}

th{

background:#2563eb;

color:white;

padding:12px;

}

td{

padding:12px;

border:1px solid #ddd;

color:#111827;

}

.resumo{

display:flex;

gap:20px;

margin-bottom:20px;

}

.card{

background:#2563eb;

color:white;

padding:20px;

border-radius:15px;

flex:1;

text-align:center;

}

.card h2{

margin:0;

font-size:32px;

}

.card p{

margin-top:10px;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>

Produção de

<?= $funcionario; ?>

</h1>

</div>

<div class="resumo">

<div class="card">

<h2>

<?= $resumo['quantidade']; ?>

</h2>

<p>Serviços</p>

</div>

<div class="card">

<h2>

R$

<?= number_format($resumo['faturamento'],2,',','.'); ?>

</h2>

<p>Faturamento</p>

</div>

<div class="card">

<h2>

R$

<?= number_format($resumo['comissao'],2,',','.'); ?>

</h2>

<p>Comissão</p>

</div>

</div>

<div class="box">

<table>

<tr>

<th>Data</th>

<th>Cliente</th>

<th>Serviço</th>

<th>Valor</th>

<th>Comissão</th>

</tr>

<?php while($item = $dados->fetchArray()) { ?>

<tr>

<td><?= $item['data_execucao']; ?></td>

<td><?= $item['cliente']; ?></td>

<td><?= $item['servico']; ?></td>

<td>

R$

<?= number_format($item['valor'],2,',','.'); ?>

</td>

<td>

R$

<?= number_format($item['comissao'],2,',','.'); ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>