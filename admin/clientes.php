<?php
include '../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Clientes</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

</head>

<body>

<div class="sidebar">

<h2>CleanManager</h2>

<a href="dashboard.php">Dashboard</a>
<a href="clientes.php">Clientes</a>
<a href="servicos.php">Serviços</a>
<a href="colaboradores.php">Colaboradores</a>

</div>

<div class="content">

<div class="topbar">
<h1>Clientes</h1>
</div>

<div class="card">

<h2>Novo Cliente</h2>

<form>

<input
type="text"
placeholder="Nome do cliente">

<input
type="text"
placeholder="Telefone">

<input
type="text"
placeholder="Endereço">

<input
type="text"
placeholder="Observações">

<button>
Cadastrar Cliente
</button>

</form>

</div>

<div class="card">

<h2>Clientes Cadastrados</h2>

<div class="table-container">

<table>

<tr>

<th>Cliente</th>
<th>Telefone</th>
<th>Total Gasto</th>
<th>Ações</th>

</tr>

<tr>

<td>Maria Oliveira</td>
<td>(47) 99999-9999</td>
<td>R$ 1.250</td>

<td>
<button>Ver</button>
</td>

</tr>

</table>

</div>

</div>

</div>

</body>
</html>