<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../auth.php';
include '../config/conexao.php';

$clientes = $db->query(
"SELECT * FROM clientes ORDER BY nome ASC"
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Perfil Cliente</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Perfil do Cliente</h1>

</div>

<div class="card">

<h2>
<?= $cliente['nome']; ?>
</h2>

<p>
<strong>Telefone:</strong>
<?= $cliente['telefone']; ?>
</p>

<p>
<strong>Endereço:</strong>
<?= $cliente['endereco']; ?>
</p>

<p>
<strong>Observações:</strong>
<?= $cliente['observacoes']; ?>
</p>

</div>

<div class="card">

<h2>Resumo Financeiro</h2>

<p>Total gasto: R$ 0,00</p>

<p>Serviços realizados: 0</p>

</div>

<div class="card">

<h2>Contato</h2>

<a
href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $cliente['telefone']); ?>"
target="_blank"
class="view-btn">

Abrir WhatsApp

</a>

</div>

</div>

</body>
</html>