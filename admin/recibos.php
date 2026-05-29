<?php

include '../config/conexao.php';

$mes = date('m');
$ano = date('Y');

if($_GET){

    $mes = $_GET['mes'];
    $ano = $_GET['ano'];
}

$historico = $db->query("

SELECT *
FROM historico_servicos

WHERE strftime('%m', data_execucao) = '$mes'
AND strftime('%Y', data_execucao) = '$ano'

ORDER BY data_execucao DESC

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

.box{

    background:white;

    padding:25px;

    border-radius:20px;

    margin-bottom:20px;
}

.box h2{

    color:#1e3a8a;

    margin-bottom:20px;
}

.box input,
.box select{

    width:100%;

    padding:14px;

    margin-bottom:15px;

    border-radius:12px;

    border:1px solid #ddd;
}

.box button{

    background:#2563eb;

    color:white;

    border:none;

    padding:12px 18px;

    border-radius:10px;

    font-weight:bold;

    cursor:pointer;
}

table{

    width:100%;

    border-collapse:collapse;

    margin-top:20px;
}

table th,
table td{

    border:1px solid #ddd;

    padding:12px;
}

table th{

    background:#2563eb;

    color:white;
}

.total{

    text-align:right;

    margin-top:20px;

    font-size:32px;

    color:#2563eb;

    font-weight:bold;
}

.actions{

    margin-top:30px;

    display:flex;

    gap:15px;
}

.btn{

    padding:14px 20px;

    border-radius:12px;

    color:white;

    text-decoration:none;

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

<div class="box">

<form method="GET">

<select name="mes">

<?php for($i=1; $i<=12; $i++) { ?>

<option
value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>"

<?= $mes == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : ''; ?>>

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

<div class="box">

<table>

<tr>

<th>Data</th>
<th>Cliente</th>
<th>Serviço</th>
<th>Valor</th>

</tr>

<?php while($item = $historico->fetchArray()) {

$total += $item['valor'];

?>

<tr>

<td>

<?= $item['data_execucao']; ?>

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

</table>

<div class="total">

Total:
R$ <?= number_format(
$total,
2,
',',
'.'
); ?>

</div>

</div>

</div>

</body>
</html>