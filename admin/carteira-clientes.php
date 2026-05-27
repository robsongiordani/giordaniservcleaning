<?php

include '../auth.php';

$db = new SQLite3(
__DIR__ . '/../database/cleanmanager.db'
);

$result = $db->query(
"SELECT * FROM clientes ORDER BY nome ASC"
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Carteira de Clientes</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Carteira de Clientes</h1>

<a
href="exportar-clientes.php"
class="export-btn">

Exportar CSV

</a>

</div>

<div class="card">

<input
type="text"
id="searchInput"
placeholder="Pesquisar cliente..."
class="search-input">

<div class="table-container">

<table id="clientesTable">

<tr>

<th>Cliente</th>
<th>Telefone</th>
<th>Endereço</th>

</tr>

<?php while($cliente = $result->fetchArray()) { ?>

<tr>

<td>
<?= $cliente['nome']; ?>
</td>

<td>
<?= $cliente['telefone']; ?>
</td>

<td>
<?= $cliente['endereco']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<script>

const input =
document.getElementById('searchInput');

input.addEventListener('keyup', function(){

let filter =
input.value.toLowerCase();

let rows =
document.querySelectorAll(
'#clientesTable tr'
);

rows.forEach((row,index)=>{

if(index === 0) return;

let text =
row.innerText.toLowerCase();

row.style.display =
text.includes(filter)
? ''
: 'none';

});

});

</script>

</body>
</html>