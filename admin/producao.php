<?php

include '../config/conexao.php';

$inicio = $_GET['inicio'] ?? date('Y-m-01');
$fim = $_GET['fim'] ?? date('Y-m-t');
$funcionario = $_GET['funcionario'] ?? '';

$where = "

WHERE date(data_execucao) BETWEEN '$inicio' AND '$fim'

";

if($funcionario != ''){
    $where .= " AND funcionario_nome = '$funcionario' ";
}

$funcionarios = $db->query("
SELECT DISTINCT funcionario_nome
FROM historico_servicos
WHERE funcionario_nome IS NOT NULL
ORDER BY funcionario_nome ASC
");

$dados = $db->query("

SELECT
funcionario_nome,
COUNT(*) as quantidade,
SUM(valor) as faturamento,
SUM(comissao) as comissao

FROM historico_servicos

$where

GROUP BY funcionario_nome

ORDER BY faturamento DESC

");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Produção</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.box{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:20px;
}

input, select{
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
    margin-right:10px;
}

button{
    padding:12px 18px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
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

tr:nth-child(even){
    background:#f8fafc;
}

tr:hover{
    background:#eef4ff;
}

.total{
    font-size:18px;
    font-weight:bold;
    margin-top:20px;
    color:#2563eb;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">
<h1>Produção de Funcionários</h1>
</div>

<div class="box">

<form method="GET">

<input type="date" name="inicio" value="<?= $inicio; ?>">

<input type="date" name="fim" value="<?= $fim; ?>">

<select name="funcionario">

<option value="">Todos Funcionários</option>

<?php while($f = $funcionarios->fetchArray()) { ?>

<option value="<?= $f['funcionario_nome']; ?>"
<?= $funcionario == $f['funcionario_nome'] ? 'selected' : ''; ?>>

<?= $f['funcionario_nome']; ?>

</option>

<?php } ?>

</select>

<button>Filtrar</button>

</form>

</div>

<div class="box">

<table>

<tr>

<th>Funcionário</th>
<th>Serviços</th>
<th>Faturamento</th>
<th>Comissão</th>

</tr>

<?php while($row = $dados->fetchArray()) { ?>

<tr>

<td><?= $row['funcionario_nome']; ?></td>

<td><?= $row['quantidade']; ?></td>

<td>R$ <?= number_format($row['faturamento'],2,',','.'); ?></td>

<td>R$ <?= number_format($row['comissao'],2,',','.'); ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php

$ranking = $db->query("

SELECT
funcionario_nome,
SUM(valor) as total

FROM historico_servicos

GROUP BY funcionario_nome

ORDER BY total DESC

LIMIT 5

");

$labels = [];
$values = [];

while($r = $ranking->fetchArray()){

    $labels[] = $r['funcionario_nome'];
    $values[] = $r['total'];
}

?>

<div class="box">

<h2>Ranking de Funcionários</h2>

<canvas id="grafico"></canvas>

</div>

</div>

<script>

const ctx = document.getElementById('grafico');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= json_encode($labels); ?>,

        datasets: [{

            label: 'Faturamento',

            data: <?= json_encode($values); ?>,

            backgroundColor: '#2563eb'

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: { display: false }

        }

    }

});

</script>

</body>
</html>