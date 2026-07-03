<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/conexao.php';

if(isset($_POST['finalizar'])){

    $agenda_id = (int)$_POST['agenda_id'];

    $comissoes = $_POST['comissao'];
    $itens_id = $_POST['item_id'];

    $agenda = $db->querySingle("
    SELECT *
    FROM agenda
    WHERE id = $agenda_id
    ", true);

    $orcamento = $db->querySingle("
    SELECT
        orcamentos.*,
        clientes.nome,
        clientes.telefone,
        clientes.endereco
    FROM orcamentos
    LEFT JOIN clientes
    ON clientes.id = orcamentos.cliente_id
    WHERE orcamentos.id = ".$agenda['orcamento_id']."
    ", true);

    foreach($itens_id as $i => $item_id){

        $item = $db->querySingle("
        SELECT *
        FROM itens_orcamento
        WHERE id = $item_id
        ", true);

        $comissao = str_replace(',','.', $comissoes[$i]);

        $db->exec("

        INSERT INTO historico_servicos
        (
            orcamento_id,
            cliente,
            telefone,
            endereco,
            servico,
            descricao,
            valor,
            data_execucao,
            status_pagamento,
            funcionario_id,
            funcionario_nome,
            comissao
        )

        VALUES
        (
            '".$agenda['orcamento_id']."',
            '".$orcamento['nome']."',
            '".$orcamento['telefone']."',
            '".$orcamento['endereco']."',
            '".$item['servico']."',
            '".$item['descricao']."',
            '".$item['valor']."',
            '".$agenda['data']."',
            'Pendente',
            '".$agenda['funcionario_id']."',
            '".$agenda['funcionario_nome']."',
            '$comissao'
        )

        ");

    }

    $db->exec("
    UPDATE agenda
    SET
        status='Concluído',
        valor='".$orcamento['total']."'
    WHERE id=$agenda_id
    ");

    header("Location: recibos.php");
    exit;

}

$id = $_GET['id'];

$agenda = $db->querySingle("

SELECT *
FROM agenda

WHERE id = '$id'

", true);

if(!$agenda){

    die('Agenda não encontrada');

}

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone,
clientes.endereco

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '".$agenda['orcamento_id']."'

", true);

if(!$orcamento){

    die('Orçamento não encontrado');

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Finalizar Serviço</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.card{

background:white;

padding:30px;

border-radius:20px;

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

input{

width:120px;

padding:8px;

}

button{

background:#16a34a;

color:white;

padding:14px 20px;

border:none;

border-radius:10px;

margin-top:20px;

font-size:16px;

cursor:pointer;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Finalizar Serviço</h1>

</div>

<div class="card">

<h2>

Cliente:

<?= $orcamento['nome']; ?>

</h2>

<p>

Funcionário:

<strong>

<?= $agenda['funcionario_nome']; ?>

</strong>

</p>

<form method="POST">

<input
type="hidden"
name="agenda_id"
value="<?= $agenda['id']; ?>">

<table>

<tr>

<th>Serviço</th>

<th>Valor</th>

<th>Comissão</th>

</tr>

<?php

$itens = $db->query("

SELECT *

FROM itens_orcamento

WHERE orcamento_id='".$agenda['orcamento_id']."'

");

while($item = $itens->fetchArray()){

?>

<tr>

<td>

<?= $item['servico']; ?>

</td>

<td>

R$

<?= number_format(
$item['valor'],
2,
',',
'.'
); ?>

</td>

<td>

<input

type="number"

step="0.01"

<input
type="hidden"
name="item_id[]"
value="<?= $item['id']; ?>">

<input
type="number"
step="0.01"
name="comissao[]"
placeholder="0,00">

placeholder="0,00">

</td>

</tr>

<?php } ?>

</table>

<button

name="finalizar">

Finalizar Serviço

</button>

</form>

</div>

</div>

</body>

</html>