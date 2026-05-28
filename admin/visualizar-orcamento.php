<?php

include '../config/conexao.php';

$id = $_GET['id'];

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '$id'

", true);

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '$id'

");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Visualizar Orçamento</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.preview{

    background:white;

    padding:40px;

    border-radius:20px;

    color:#0f172a;
}

.preview-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    border-bottom:2px solid #2563eb;

    padding-bottom:20px;

    margin-bottom:20px;
}

.preview-header h1{

    color:#1e3a8a;

    margin-top:10px;
}

.preview-header p{

    margin:5px 0;

    color:#334155;
}

.preview table{

    width:100%;

    border-collapse:collapse;

    margin-top:20px;
}

.preview table th,
.preview table td{

    border:1px solid #ddd;

    padding:12px;
}

.preview table th{

    background:#2563eb;

    color:white;
}

.preview table td{

    color:#0f172a;
}

.total{

    text-align:right;

    margin-top:30px;
}

.total h1{

    color:#2563eb;
}

.btns{

    display:flex;

    gap:15px;

    margin-top:30px;

    flex-wrap:wrap;
}

.btn{

    padding:14px 20px;

    border-radius:12px;

    text-decoration:none;

    color:white;

    font-weight:bold;

    display:inline-block;
}

.whatsapp{

    background:#22c55e;
}

.pdf{

    background:#7c3aed;
}

.approve{

    background:#0f766e;
}

.client-box{

    background:#f8fafc;

    padding:18px;

    border-radius:12px;

    margin-top:20px;

    border:1px solid #e2e8f0;
}

.client-box p{

    margin:6px 0;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>

Orçamento #<?= $orcamento['id']; ?>

</h1>

</div>

<div class="preview">

<div class="preview-header">

<div>

<img
src="../assets/img/logo.png"
width="180">

<h1>Giordani Cleaning</h1>

<p>
(47) 99213-2615
</p>

<p>
(47) 99183-3664
</p>

<p>
Serviços de Limpeza,
Lavanderia e Manutenção
</p>

<p>
Atendimento em Balneário Piçarras,
Penha e Barra Velha
</p>

</div>

<img
src="../assets/img/caricatura.png"
width="220">

</div>

<div class="client-box">

<p>

<strong>Cliente:</strong>

<?= $orcamento['nome']; ?>

</p>

<p>

<strong>Telefone:</strong>

<?= $orcamento['telefone']; ?>

</p>

<p>

<strong>Data:</strong>

<?= $orcamento['data']; ?>

</p>

<p>

<strong>Status:</strong>

<?= $orcamento['status']; ?>

</p>

</div>

<table>

<thead>

<tr>

<th>Serviço</th>
<th>Descrição</th>
<th>Valor</th>

</tr>

</thead>

<tbody>

<?php while($item = $itens->fetchArray()) { ?>

<tr>

<td>

<?= $item['servico']; ?>

</td>

<td>

<?= $item['descricao']; ?>

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
$orcamento['total'],
2,
',',
'.'
); ?>

</h1>

</div>

<div class="btns">

<a
href="gerar-pdf.php?id=<?= $orcamento['id']; ?>"
class="btn pdf">

Gerar PDF

</a>

<a
target="_blank"
href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $orcamento['telefone']); ?>?text=Olá <?= $orcamento['nome']; ?>! Segue seu orçamento da Giordani Cleaning."
class="btn whatsapp">
Abrir WhatsApp

</a>

<a
href="aprovar-orcamento.php?id=<?= $orcamento['id']; ?>"
class="btn approve">

Aprovar Orçamento
<a
href="excluir-orcamento.php?id=<?= $orcamento['id']; ?>"
class="btn"

style="background:#ef4444;">

Excluir

</a>

</div>

</div>

</div>

</body>
</html>