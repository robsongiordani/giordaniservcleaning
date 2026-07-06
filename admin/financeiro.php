<?php

include '../config/conexao.php';

$hoje = date('Y-m-d');

$inicioSemana = date('Y-m-d', strtotime('monday this week'));
$fimSemana = date('Y-m-d', strtotime('sunday this week'));

$inicioMes = date('Y-m-01');
$fimMes = date('Y-m-t');

function totalCampo($db,$campo,$inicio,$fim){

    $sql = "

    SELECT SUM($campo) as total

    FROM historico_servicos

    WHERE date(data_execucao)

    BETWEEN '$inicio'

    AND '$fim'

    ";

    $r = $db->querySingle($sql,true);

    return $r['total'] ?? 0;

}

function quantidade($db,$inicio,$fim){

    $sql="

    SELECT COUNT(*) as total

    FROM historico_servicos

    WHERE date(data_execucao)

    BETWEEN '$inicio'

    AND '$fim'

    ";

    $r=$db->querySingle($sql,true);

    return $r['total'];

}

$fatHoje=totalCampo($db,'valor',$hoje,$hoje);
$lucroHoje=totalCampo($db,'lucro',$hoje,$hoje);
$comHoje=totalCampo($db,'comissao',$hoje,$hoje);

$fatSemana=totalCampo($db,'valor',$inicioSemana,$fimSemana);
$lucroSemana=totalCampo($db,'lucro',$inicioSemana,$fimSemana);
$comSemana=totalCampo($db,'comissao',$inicioSemana,$fimSemana);

$fatMes=totalCampo($db,'valor',$inicioMes,$fimMes);
$lucroMes=totalCampo($db,'lucro',$inicioMes,$fimMes);
$comMes=totalCampo($db,'comissao',$inicioMes,$fimMes);

$servicosMes=quantidade($db,$inicioMes,$fimMes);

?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Financeiro</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.cards{

display:grid;

grid-template-columns:repeat(auto-fit,minmax(250px,1fr));

gap:20px;

margin-bottom:30px;

}

.card{

background:white;

padding:25px;

border-radius:20px;

box-shadow:0 2px 8px rgba(0,0,0,.08);

}

.card h3{

margin:0;

color:#64748b;

font-size:16px;

}

.valor{

margin-top:15px;

font-size:34px;

font-weight:bold;

color:#2563eb;

}

.bloco{

background:white;

padding:25px;

border-radius:20px;

margin-top:30px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

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

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Financeiro</h1>

</div>

<h2>Hoje</h2>

<div class="cards">

<div class="card">

<h3>Faturamento</h3>

<div class="valor">

R$ <?= number_format($fatHoje,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Lucro</h3>

<div class="valor">

R$ <?= number_format($lucroHoje,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Comissões</h3>

<div class="valor">

R$ <?= number_format($comHoje,2,',','.'); ?>

</div>

</div>

</div>

<h2>Esta Semana</h2>

<div class="cards">

<div class="card">

<h3>Faturamento</h3>

<div class="valor">

R$ <?= number_format($fatSemana,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Lucro</h3>

<div class="valor">

R$ <?= number_format($lucroSemana,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Comissões</h3>

<div class="valor">

R$ <?= number_format($comSemana,2,',','.'); ?>

</div>

</div>

</div>

<h2>Este Mês</h2>

<div class="cards">

<div class="card">

<h3>Faturamento</h3>

<div class="valor">

R$ <?= number_format($fatMes,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Lucro</h3>

<div class="valor">

R$ <?= number_format($lucroMes,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Comissões</h3>

<div class="valor">

R$ <?= number_format($comMes,2,',','.'); ?>

</div>

</div>

<div class="card">

<h3>Serviços Executados</h3>

<div class="valor">

<?= $servicosMes; ?>

</div>

</div>

</div>

<div class="bloco">

<h2>Últimos Serviços</h2>

<table>

<tr>

<th>Data</th>

<th>Cliente</th>

<th>Funcionário</th>

<th>Valor</th>

<th>Comissão</th>

<th>Lucro</th>

<th>Ações</th>

</tr>

<?php

$lista=$db->query("

SELECT *

FROM historico_servicos

ORDER BY id DESC

LIMIT 20

");

while($item=$lista->fetchArray()){

?>

<tr>

<td><?= $item['data_execucao']; ?></td>

<td><?= $item['cliente']; ?></td>

<td><?= $item['funcionario_nome']; ?></td>

<td>R$ <?= number_format($item['valor'],2,',','.'); ?></td>

<td>R$ <?= number_format($item['comissao'],2,',','.'); ?></td>

<td>R$ <?= number_format($item['lucro'],2,',','.'); ?></td>

<td>

<a

href="editar-comissao.php?id=<?= $item['id']; ?>"

style="

background:#2563eb;

padding:8px 14px;

color:white;

text-decoration:none;

border-radius:8px;

">

Editar

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>