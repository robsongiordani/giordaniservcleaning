<?php

include '../config/conexao.php';

$cliente = $_GET['cliente'] ?? '';
$mes = $_GET['mes'] ?? date('m');
$ano = $_GET['ano'] ?? date('Y');

$where = "";

if($cliente != ''){

    $where .= "
    AND cliente LIKE '%$cliente%'
    ";
}

$historico = $db->query("

SELECT *
FROM historico_financeiro

WHERE strftime('%m', data) = '$mes'
AND strftime('%Y', data) = '$ano'

$where

ORDER BY data ASC

");

$total = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Recibos</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.filter-box{

    background:white;

    padding:25px;

    border-radius:20px;

    margin-bottom:20px;
}

.filter-box input,
.filter-box select{

    padding:12px;

    border-radius:10px;

    border:1px solid #ddd;

    margin-right:10px;
}

.filter-box button{

    padding:12px 18px;

    background:#2563eb;

    color:white;

    border:none;

    border-radius:10px;

    cursor:pointer;
}

.recibo{

    background:white;

    padding:30px;

    border-radius:20px;
}

table{

    width:100%;

    border-collapse:collapse;

    margin-top:20px;
}

table th{

    background:#2563eb;

    color:white;

    padding:12px;

    text-align:left;
}

table td{

    border:1px solid #ddd;

    padding:12px;
}

.total{

    margin-top:30px;

    text-align:right;
}

.total h1{

    color:#2563eb;
}

.btns{

    margin-top:30px;

    display:flex;

    gap:15px;
}

.btn{

    padding:14px 20px;

    border-radius:12px;

    text-decoration:none;

    color:white;

    font-weight:bold;
}

.pdf{

    background:#7c3aed;
}

.whatsapp{

    background:#22c55e;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Recibos</h1>

</div>

<div class="filter-box">

<form method="GET">

<input
type="text"
name="cliente"
placeholder="Cliente"
value="<?= $cliente; ?>">

<select name="mes">

<?php for($i=1; $i<=12; $i++) { ?>

<option
value="<?= str_pad($i,2,'0',STR_PAD_LEFT); ?>"

<?= $mes == str_pad($i,2,'0',STR_PAD_LEFT) ? 'selected' : ''; ?>>

<?= $i; ?>

</option>

<?php } ?>

</select>

<input
type="number"
name="ano"
value="<?= $ano; ?>">

<button>

Filtrar

</button>

</form>

</div>

<div class="recibo">

<h2>

Recibo Mensal

</h2>

<table>

<thead>

<tr>

<th>Data</th>
<th>Cliente</th>
<th>Serviço</th>
<th>Valor</th>

</tr>

</thead>

<tbody>

<?php while($item = $historico->fetchArray()) {

$total += $item['valor'];

?>

<tr>

<td>

<?= $item['data']; ?>

</td>

<td>

<?= $item['cliente']; ?>

</td>

<td>

<?= $item['servico']; ?>

</td>

<td>

R$ <?= number_format(
$item['valor'],
2,
',',
'.'
); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<div class="total">

<h1>

Total:
R$ <?= number_format(
$total,
2,
',',
'.'
); ?>

</h1>

</div>

<div class="btns">

<a
href="#"
class="btn pdf">

Gerar PDF

</a>

<a
href="#"
class="btn whatsapp">

WhatsApp

</a>

</div>

</div>

</div>

</body>
</html>