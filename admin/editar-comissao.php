<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/conexao.php';

$id=(int)$_GET['id'];

$servico=$db->querySingle("

SELECT *

FROM historico_servicos

WHERE id=$id

",true);

if(!$servico){

die("Registro não encontrado.");

}
?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Comissão</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.card{

background:#fff;

padding:30px;

border-radius:20px;

max-width:700px;

}

input{

width:100%;

padding:12px;

border-radius:10px;

border:1px solid #ddd;

margin-top:8px;

margin-bottom:20px;

}

button{

background:#2563eb;

color:white;

padding:14px 20px;

border:none;

border-radius:10px;

cursor:pointer;

}

.info{

    color:#111827;

    font-size:18px;

    margin-bottom:18px;

    font-weight:600;

}

label{

    color:#111827;

    font-weight:bold;

    display:block;

    margin-bottom:8px;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Editar Comissão</h1>

</div>

<div class="card">

<div class="info">

<b>Cliente:</b>

<?= $servico['cliente']; ?>

</div>

<div class="info">

<b>Funcionário:</b>

<?= $servico['funcionario_nome']; ?>

</div>

<div class="info">

<b>Serviço:</b>

<?= $servico['servico']; ?>

</div>

<form method="POST" action="salvar-comissao.php">

<input
type="hidden"
name="id"
value="<?= $servico['id']; ?>">

<label>

Valor do Serviço

</label>

<input

type="text"

id="valor"

value="<?= $servico['valor']; ?>"

readonly>

<label>

Comissão

</label>

<input

type="number"

step="0.01"

name="comissao"

id="comissao"

value="<?= $servico['comissao']; ?>"

onkeyup="calcular()">

<label>

Lucro

</label>

<input

type="text"

id="lucro"

value="<?= $servico['lucro']; ?>"

readonly>

<button>

Salvar Alterações

</button>

</form>

</div>

</div>

<script>

function calcular(){

let valor=parseFloat(document.getElementById('valor').value)||0;

let comissao=parseFloat(document.getElementById('comissao').value)||0;

document.getElementById('lucro').value=(valor-comissao).toFixed(2);

}

calcular();

</script>

</body>

</html>