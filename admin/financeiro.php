<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/conexao.php';

/* ===========================
   FILTROS
=========================== */

$cliente      = $_GET['cliente'] ?? '';
$funcionario  = $_GET['funcionario'] ?? '';
$status       = $_GET['status'] ?? '';
$inicio       = $_GET['inicio'] ?? '';
$fim          = $_GET['fim'] ?? '';

$where = " WHERE 1=1 ";

if($cliente!=''){
    $where .= " AND cliente LIKE '%$cliente%'";
}

if($funcionario!=''){
    $where .= " AND funcionario_nome LIKE '%$funcionario%'";
}

if($status!=''){
    $where .= " AND status_pagamento='$status'";
}

if($inicio!=''){
    $where .= " AND date(data_execucao)>='$inicio'";
}

if($fim!=''){
    $where .= " AND date(data_execucao)<='$fim'";
}

/* ===========================
   DATAS
=========================== */

$hoje = date('Y-m-d');

$inicioSemana = date('Y-m-d',strtotime('monday this week'));
$fimSemana    = date('Y-m-d',strtotime('sunday this week'));

$inicioMes = date('Y-m-01');
$fimMes    = date('Y-m-t');

/* ===========================
   FUNÇÕES
=========================== */

function totalCampo($db,$campo,$inicio,$fim){

    $sql="

    SELECT SUM($campo) total

    FROM historico_servicos

    WHERE date(data_execucao)

    BETWEEN '$inicio'

    AND '$fim'

    ";

    $r=$db->querySingle($sql,true);

    return $r['total'] ?? 0;

}

function quantidade($db,$inicio,$fim){

    $sql="

    SELECT COUNT(*) total

    FROM historico_servicos

    WHERE date(data_execucao)

    BETWEEN '$inicio'

    AND '$fim'

    ";

    $r=$db->querySingle($sql,true);

    return $r['total'];

}

/* ===========================
   RESUMOS
=========================== */

$fatHoje     = totalCampo($db,'valor',$hoje,$hoje);
$lucroHoje   = totalCampo($db,'lucro',$hoje,$hoje);
$comHoje     = totalCampo($db,'comissao',$hoje,$hoje);

$fatSemana   = totalCampo($db,'valor',$inicioSemana,$fimSemana);
$lucroSemana = totalCampo($db,'lucro',$inicioSemana,$fimSemana);
$comSemana   = totalCampo($db,'comissao',$inicioSemana,$fimSemana);

$fatMes      = totalCampo($db,'valor',$inicioMes,$fimMes);
$lucroMes    = totalCampo($db,'lucro',$inicioMes,$fimMes);
$comMes      = totalCampo($db,'comissao',$inicioMes,$fimMes);

$servicosMes = quantidade($db,$inicioMes,$fimMes);

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

grid-template-columns:repeat(auto-fit,minmax(240px,1fr));

gap:20px;

margin-bottom:30px;

}

.card{

background:#fff;

padding:25px;

border-radius:20px;

box-shadow:0 2px 8px rgba(0,0,0,.08);

}

.card h3{

margin:0;

font-size:16px;

color:#111827;

}

.valor{

margin-top:15px;

font-size:32px;

font-weight:bold;

color:#2563eb;

}

.box{

background:#fff;

padding:20px;

border-radius:20px;

margin-bottom:25px;

}

.box input,
.box select{

padding:12px;

border-radius:10px;

border:1px solid #ddd;

margin-right:10px;

margin-bottom:10px;

}

.box button{

padding:12px 20px;

background:#2563eb;

color:#fff;

border:none;

border-radius:10px;

cursor:pointer;

}

.bloco{

background:#fff;

padding:25px;

border-radius:20px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

th{

background:#2563eb;

color:#fff;

padding:12px;

}

td{

padding:12px;

border:1px solid #ddd;

color:#111827;

}

tr:nth-child(even){

background:#f8fafc;

}

tr:hover{

background:#eef4ff;

}

.editar{

background:#2563eb;

padding:8px 14px;

border-radius:8px;

color:white;

text-decoration:none;

font-weight:bold;

display:inline-block;

margin-right:6px;

}

.receber{

background:#16a34a;

padding:8px 14px;

border-radius:8px;

color:white;

text-decoration:none;

font-weight:bold;

display:inline-block;

}

.status-ok{

color:#16a34a;

font-weight:bold;

}

.status-pendente{

color:#dc2626;

font-weight:bold;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Financeiro</h1>

</div>

<div class="box">

<form method="GET">

<input
type="text"
name="cliente"
placeholder="Cliente"
value="<?= htmlspecialchars($cliente); ?>">

<input
type="text"
name="funcionario"
placeholder="Funcionário"
value="<?= htmlspecialchars($funcionario); ?>">

<input
type="date"
name="inicio"
value="<?= $inicio; ?>">

<input
type="date"
name="fim"
value="<?= $fim; ?>">

<select name="status">

<option value="">Todos</option>

<option
value="Recebido"
<?= $status=="Recebido" ? "selected" : ""; ?>>

Recebido

</option>

<option
value="Pendente"
<?= $status=="Pendente" ? "selected" : ""; ?>>

Pendente

</option>

</select>

<button type="submit">

Filtrar

</button>

</form>

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

<th>Status</th>

<th>Forma</th>

<th>Recebimento</th>

<th>Ações</th>

</tr>

<?php

$lista = $db->query("

SELECT *

FROM historico_servicos

$where

ORDER BY id DESC

LIMIT 50

");

while($item = $lista->fetchArray()){

?>

<tr>

<td><?= $item['data_execucao']; ?></td>

<td><?= htmlspecialchars($item['cliente']); ?></td>

<td><?= htmlspecialchars($item['funcionario_nome']); ?></td>

<td>

R$ <?= number_format($item['valor'],2,',','.'); ?>

</td>

<td>

R$ <?= number_format($item['comissao'],2,',','.'); ?>

</td>

<td>

R$ <?= number_format($item['lucro'],2,',','.'); ?>

</td>

<td>

<?php if($item['status_pagamento']=="Recebido"){ ?>

<span style="color:#16a34a;font-weight:bold;">
🟢 Recebido
</span>

<?php }else{ ?>

<span style="color:#dc2626;font-weight:bold;">
🔴 Pendente
</span>

<?php } ?>

</td>

<td>

<?= !empty($item['forma_pagamento']) ? htmlspecialchars($item['forma_pagamento']) : "-"; ?>

</td>

<td>

<?= !empty($item['data_recebimento']) ? $item['data_recebimento'] : "-"; ?>

</td>

<td>

<a

href="editar-comissao.php?id=<?= $item['id']; ?>"

class="editar">

Editar

</a>

<?php if($item['status_pagamento']!="Recebido"){ ?>

<a

href="receber.php?id=<?= $item['id']; ?>"

class="receber">

Receber

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>