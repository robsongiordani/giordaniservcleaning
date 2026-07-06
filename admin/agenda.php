<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/conexao.php';

$agenda = $db->query("

SELECT *

FROM agenda

ORDER BY

CASE

WHEN status='Agendado' THEN 1
WHEN status='Em andamento' THEN 2
WHEN status='Concluído' THEN 3
ELSE 4

END,

data ASC,
horario ASC

");

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Agenda</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.agenda-card{

background:#fff;

padding:25px;

border-radius:20px;

margin-bottom:20px;

box-shadow:0 3px 10px rgba(0,0,0,.08);

}

.agenda-card h2{

color:#1e3a8a;

margin-bottom:15px;

}

.agenda-card p{

margin:8px 0;

color:#334155;

}

.status{

color:#fff;

padding:8px 14px;

border-radius:20px;

display:inline-block;

font-weight:bold;

}

.agendado{

background:#f59e0b;

}

.andamento{

background:#2563eb;

}

.concluido{

background:#16a34a;

}

.action-btn{

display:inline-block;

padding:10px 16px;

border-radius:10px;

text-decoration:none;

color:#fff;

font-weight:bold;

margin-right:10px;

margin-top:10px;

}

.start{

background:#2563eb;

}

.finish{

background:#16a34a;

}

.delete{

background:#dc2626;

}

.action-area{

margin-top:20px;

}

select{

padding:10px;

border-radius:8px;

border:1px solid #d1d5db;

width:280px;

}

button{

padding:10px 18px;

border:none;

border-radius:8px;

background:#2563eb;

color:white;

cursor:pointer;

margin-left:10px;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Agenda de Serviços</h1>

</div>

<?php while($item=$agenda->fetchArray()){ ?>

<div class="agenda-card">

<h2>

<?= $item['os_numero']; ?>

</h2>

<p>

<strong>Cliente:</strong>

<?= $item['cliente']; ?>

</p>

<p>

<strong>Telefone:</strong>

<?= $item['telefone']; ?>

</p>

<p>

<strong>Serviços:</strong>

<?= $item['servicos']; ?>

</p>

<p>

<strong>Data:</strong>

<?= $item['data']; ?>

</p>

<p>

<strong>Horário:</strong>

<?= $item['horario']; ?>

</p>

<p>

<strong>Observações:</strong>

<?= $item['observacoes']; ?>

</p>

<?php

$funcionarios = $db->query("

SELECT *

FROM funcionarios

WHERE ativo=1

ORDER BY nome

");

?>

<form

method="POST"

action="salvar-funcionario-agenda.php">

<input

type="hidden"

name="agenda_id"

value="<?= $item['id']; ?>">

<label>

<strong>Funcionário:</strong>

</label>

<br><br>

<select name="funcionario_id">

<option value="">

Selecione...

</option>

<?php while($f=$funcionarios->fetchArray()){ ?>

<option

value="<?= $f['id']; ?>"

<?= ($item['funcionario_id']==$f['id'])?'selected':''; ?>>

<?= $f['nome']; ?>

</option>

<?php } ?>

</select>

<button>

Salvar

</button>

</form>

<div class="action-area">

<?php if($item['status']=='Agendado'){ ?>

<span class="status agendado">

Agendado

</span>

<a
href="iniciar-servico.php?id=<?= $item['id']; ?>"
class="action-btn start">

Iniciar Serviço

</a>

<a
href="excluir-os.php?id=<?= $item['id']; ?>"
class="action-btn delete"
onclick="return confirm('Deseja realmente excluir esta Ordem de Serviço?\n\nTodos os dados relacionados serão apagados.\n\nDeseja continuar?');">

Excluir OS

</a>

<?php } ?>

<?php if($item['status']=='Em andamento'){ ?>

<span class="status andamento">

Em andamento

</span>

<a
href="finalizar-servico.php?id=<?= $item['id']; ?>"
class="action-btn finish">

Finalizar Serviço

</a>

<a
href="excluir-os.php?id=<?= $item['id']; ?>"
class="action-btn delete"
onclick="return confirm('Deseja realmente excluir esta Ordem de Serviço?\n\nTodos os dados relacionados serão apagados.\n\nDeseja continuar?');">

Excluir OS

</a>

<?php } ?>

<?php if($item['status']=='Concluído'){ ?>

<span class="status concluido">

Concluído

</span>

<a
href="recibos.php?os=<?= $item['orcamento_id']; ?>"
class="action-btn start">

Ver Recibo

</a>

<a
href="excluir-os.php?id=<?= $item['id']; ?>"
class="action-btn delete"
onclick="return confirm('Deseja realmente excluir esta Ordem de Serviço?\n\nTodos os dados relacionados serão apagados.\n\nDeseja continuar?');">

Excluir OS

</a>

<?php } ?>

</div>

</div>

<?php } ?>

</div>

</body>

</html>