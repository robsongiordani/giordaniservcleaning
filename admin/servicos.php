<?php
include '../auth.php';
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

<form>

<div class="input-group">

<label>Cliente</label>

<select>

<option>Selecionar Cliente</option>
<option>Maria Oliveira</option>

</select>

</div>

<div class="input-group">

<label>Tipo de Serviço</label>

<select>

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
placeholder="0,00">

</div>

<div class="input-group">

<label>Data</label>

<input type="date">

</div>

<button>

Salvar Atendimento

</button>

</form>

</div>

<div class="card">

<h2>Atendimentos</h2>

<div class="table-container">

<table>

<tr>

<td>Maria Oliveira</td>

<td>

<div class="multi-service">

<span>
Faxina — R$180
</span>

<span>
Lavanderia — R$80
</span>

<span>
Airbnb — R$220
</span>

</div>

</td>

<td>

<span class="status concluido">
Concluído
</span>

</td>

</tr>

<td>Maria Oliveira</td>
<td>Faxina</td>
<td>R$ 180</td>

<td>
<span class="status concluido">
Concluído
</span>
</td>

</tr>

</table>

</div>

</div>

</div>

</body>
</html>