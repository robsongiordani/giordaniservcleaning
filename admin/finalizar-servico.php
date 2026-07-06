<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/conexao.php';

if(isset($_POST['finalizar'])){

    $agenda_id = (int)$_POST['agenda_id'];

    $agenda = $db->querySingle("
        SELECT *
        FROM agenda
        WHERE id = $agenda_id
    ", true);

    if(!$agenda){
        die("Agenda não encontrada.");
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
        WHERE orcamentos.id = ".$agenda['orcamento_id']."
    ", true);

    if(!$orcamento){
        die("Orçamento não encontrado.");
    }

    $observacoes = SQLite3::escapeString($_POST['observacoes']);

    foreach($_POST['item_id'] as $i => $item_id){

        $item = $db->querySingle("
            SELECT *
            FROM itens_orcamento
            WHERE id = ".(int)$item_id."
        ", true);

        if(!$item){
            continue;
        }

        $comissao = (float)str_replace(",",".",$_POST['comissao'][$i]);

if($comissao > $item['valor']){
    $comissao = $item['valor'];
}

$lucro = $item['valor'] - $comissao;

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
            comissao,
            lucro,
            observacoes,
            data_finalizacao
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
           '$comissao',
'$lucro',
            '$observacoes',
            '".date('Y-m-d H:i:s')."'
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

$id = (int)$_GET['id'];

$agenda = $db->querySingle("

SELECT *

FROM agenda

WHERE id = $id

", true);

if(!$agenda){
    die("Agenda não encontrada.");
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

WHERE orcamentos.id = ".$agenda['orcamento_id']."

", true);

if(!$orcamento){
    die("Orçamento não encontrado.");
}

$itens = $db->query("

SELECT *

FROM itens_orcamento

WHERE orcamento_id=".$agenda['orcamento_id']."

");

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Finalizar Serviço</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

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

input[type=number]{
    width:120px;
    padding:8px;
}

textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    resize:vertical;
}

button{
    background:#16a34a;
    color:white;
    padding:14px 20px;
    border:none;
    border-radius:10px;
    margin-top:20px;
    cursor:pointer;
    font-size:16px;
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
<strong><?= $orcamento['nome']; ?></strong>

</h2>

<p>

Funcionário:
<strong><?= $agenda['funcionario_nome']; ?></strong>

</p>

<p>

Data do Serviço:
<strong><?= $agenda['data']; ?></strong>

</p>

<form method="POST">

<input
type="hidden"
name="agenda_id"
value="<?= $agenda['id']; ?>">

<table>

<tr>

<th>Serviço</th>

<th>Descrição</th>

<th>Valor</th>

<th>Comissão</th>

</tr>

<?php while($item = $itens->fetchArray()) { ?>

<tr>

<td>

<?= $item['servico']; ?>

</td>

<td>

<?= $item['descricao']; ?>

</td>

<td>

R$

<?= number_format($item['valor'],2,',','.'); ?>

</td>

<td>

<input
type="hidden"
name="item_id[]"
value="<?= $item['id']; ?>">

<input
type="number"
step="0.01"
min="0"
name="comissao[]"
placeholder="0,00"
required>

</td>

</tr>

<?php } ?>

</table>

<br>

<label>

<b>Observações da execução</b>

</label>

<br><br>

<textarea

name="observacoes"

rows="5"

placeholder="Descreva como foi realizado o serviço, observações importantes, materiais utilizados, problemas encontrados..."></textarea>

<br>

<button
type="submit"
name="finalizar">

Finalizar Serviço

</button>

<a

href="agenda.php"

style="

margin-left:15px;
background:#64748b;
color:white;
padding:14px 20px;
border-radius:10px;
text-decoration:none;

">

Cancelar

</a>

</form>

</div>

</div>

</body>

</html>