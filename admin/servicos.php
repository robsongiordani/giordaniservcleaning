<?php

include '../auth.php';
include '../config/conexao.php';

if(isset($_POST['salvar'])){

    $cliente_id = $_POST['cliente_id'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];

    $db->exec("
    INSERT INTO servicos
    (
        cliente_id,
        tipo,
        valor,
        data
    )

    VALUES
    (
        '$cliente_id',
        '$tipo',
        '$valor',
        '$data'
    )
    ");
}

$clientes = $db->query(
"SELECT * FROM clientes ORDER BY nome ASC"
);

$servicos = $db->query("
SELECT servicos.*, clientes.nome

FROM servicos

LEFT JOIN clientes
ON clientes.id = servicos.cliente_id

ORDER BY servicos.id DESC
");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Serviços</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Serviços</h1>

</div>

<div class="card">

<h2>Novo Atendimento</h2>

<form method="POST">

<div class="input-group">

<label>Cliente</label>

<select
name="cliente_id"
required>

<option value="">
Selecionar Cliente
</option>

<?php while($cliente = $clientes->fetchArray()) { ?>

<option
value="<?= $cliente['id']; ?>">

<?= $cliente['nome']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>Tipo de Serviço</label>

<select name="tipo">

<option>Faxina</option>
<option>Meia-faxina</option>
<option>Pós-obra</option>
<option>Pós-reforma</option>
<option>Airbnb</option>
<option>Manutenção</option>
<option>Lavanderia</option>

</select>

</div>

<div class="input-group">

<label>Valor</label>

<input
type="number"
step="0.01"
name="valor"
required>

</div>

<div class="input-group">

<label>Data</label>

<input
type="date"
name="data">

</div>

<button
type="submit"
name="salvar">

Salvar Atendimento

</button>

</form>

</div>

<div class="card">

<h2>Atendimentos</h2>

<div class="table-container">

<table>

<tr>

<th>Cliente</th>
<th>Serviço</th>
<th>Valor</th>
<th>Data</th>

</tr>

<?php while($servico = $servicos->fetchArray()) { ?>

<tr>

<td>
<?= $servico['nome']; ?>
</td>

<td>
<?= $servico['tipo']; ?>
</td>

<td>
R$ <?= number_format($servico['valor'],2,',','.'); ?>
</td>

<td>
<?= $servico['data']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>