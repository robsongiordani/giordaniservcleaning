<?php

include '../config/conexao.php';

$orcamentos = $db->query("

SELECT
orcamentos.*,
clientes.nome

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

ORDER BY orcamentos.id DESC

");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Orçamentos</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.status{

    padding:8px 14px;

    border-radius:20px;

    color:white;

    font-size:14px;

    font-weight:bold;
}

.pendente{

    background:#f59e0b;
}

.aprovado{

    background:#22c55e;
}

.concluido{

    background:#2563eb;
}

.actions{

    display:flex;

    gap:10px;

    flex-wrap:wrap;
}

.action-btn{

    border:none;

    padding:10px 15px;

    border-radius:10px;

    cursor:pointer;

    color:white;

    text-decoration:none;

    font-size:14px;
}

.view{

    background:#2563eb;
}

.whatsapp{

    background:#22c55e;
}

.approve{

    background:#0f766e;
}

.table-container{

    overflow:auto;
}

table{

    width:100%;

    border-collapse:collapse;
}

table th,
table td{

    padding:15px;

    border-bottom:1px solid #eee;

    text-align:left;
}

table th{

    background:#f8fafc;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Orçamentos</h1>

</div>

<div class="card">

<div class="table-container">

<table>

<thead>

<tr>

<th>#</th>
<th>Cliente</th>
<th>Data</th>
<th>Total</th>
<th>Status</th>
<th>Ações</th>

</tr>

</thead>

<tbody>

<?php while($orcamento = $orcamentos->fetchArray()) { ?>

<tr>

<td>

#<?= $orcamento['id']; ?>

</td>

<td>

<?= $orcamento['nome']; ?>

</td>

<td>

<?= $orcamento['data']; ?>

</td>

<td>

R$ <?= number_format(
$orcamento['total'],
2,
',',
'.'
); ?>

</td>

<td>

<span class="status pendente">

<?= $orcamento['status']; ?>

</span>

</td>

<td>

<div class="actions">

<a
href="visualizar-orcamento.php?id=<?= $orcamento['id']; ?>"
class="action-btn view">

Ver

</a>

<a
target="_blank"
href="https://wa.me/?text=Segue seu orçamento da Giordani Cleaning">

WhatsApp

</a>

<a
href="#"
class="action-btn approve">

Aprovar

</a>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>