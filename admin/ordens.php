<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/conexao.php';

if(isset($_POST['salvar'])){

    $cliente_id = $_POST['cliente'];
    $observacoes = $_POST['observacoes'];
    $total = $_POST['total'];
    $data = date('d/m/Y');

    $db->exec("
    INSERT INTO orcamentos
    (
        cliente_id,
        observacoes,
        total,
        status,
        data
    )

    VALUES
    (
        '$cliente_id',
        '$observacoes',
        '$total',
        'Pendente',
        '$data'
    )
    ");

    $orcamento_id =
    $db->lastInsertRowID();

    if(isset($_POST['servico'])){

        foreach($_POST['servico'] as $index => $servico){

            $descricao =
            $_POST['descricao'][$index];

            $valor =
            $_POST['valor'][$index];

            $db->exec("
            INSERT INTO itens_orcamento
            (
                orcamento_id,
                servico,
                descricao,
                valor
            )

            VALUES
            (
                '$orcamento_id',
                '$servico',
                '$descricao',
                '$valor'
            )
            ");
        }
    }

    echo "
    <script>
    alert('Orçamento salvo com sucesso!');
    </script>
    ";
}

$clientes = $db->query(
"SELECT * FROM clientes ORDER BY nome ASC"
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Ordens de Serviço</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.service-item{

    display:grid;

    grid-template-columns:2fr 2fr 1fr auto;

    gap:10px;

    margin-bottom:15px;
}

.add-btn{

    background:#22c55e;

    color:white;

    border:none;

    padding:12px 18px;

    border-radius:12px;

    cursor:pointer;
}

.remove-btn{

    background:#ef4444;

    color:white;

    border:none;

    padding:10px 14px;

    border-radius:10px;

    cursor:pointer;
}

.total-box{

    margin-top:20px;

    background:#eff6ff;

    padding:20px;

    border-radius:15px;

    text-align:right;
}

.total-box p{

    color:#334155;

}

.total-box h2{

    color:#2563eb;

    font-size:32px;
}

.preview{

    margin-top:30px;

    background:white;

    padding:30px;

    border-radius:20px;

    color:#1e293b;
}

.preview-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    border-bottom:2px solid #2563eb;

    padding-bottom:20px;

    margin-bottom:20px;
}

.preview-header h1{

    color:#1e3a8a;

}

.preview-header p{

    color:#334155;

    line-height:1.6;
}

.preview-logo{

    width:180px;
}

.preview table{

    width:100%;

    border-collapse:collapse;

    margin-top:20px;
}

.preview table th,
.preview table td{

    border:1px solid #ddd;

    padding:12px;
}

.preview table th{

    background:#2563eb;

    color:white;
}

.preview table td{

    color:#0f172a;
}

.preview h2{

    color:#1e3a8a;

}

.generate-btn{

    background:#2563eb;

    color:white;

    border:none;

    padding:15px 25px;

    border-radius:14px;

    cursor:pointer;

    margin-top:20px;

    font-size:16px;
}

textarea{

    width:100%;

    min-height:100px;

    border-radius:12px;

    padding:15px;

    border:1px solid #ddd;

    margin-top:10px;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Nova Ordem de Serviço</h1>

</div>

<div class="card">

<form method="POST">

<div class="input-group">

<label>Cliente</label>

<select
name="cliente"
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

<label>Observações</label>

<textarea
name="observacoes"
placeholder="Detalhes do orçamento">
</textarea>

</div>

<div id="services-container">

<div class="service-item">

<select name="servico[]">

<option>Faxina</option>
<option>Lavanderia</option>
<option>Airbnb</option>
<option>Pós-obra</option>
<option>Manutenção</option>

</select>

<input
type="text"
name="descricao[]"
placeholder="Descrição">

<input
type="number"
step="0.01"
name="valor[]"
placeholder="Valor"
class="valor">

<button
type="button"
class="remove-btn"
onclick="this.parentElement.remove(); calcularTotal(); atualizarPreview();">

X

</button>

</div>

</div>

<button
type="button"
class="add-btn"
onclick="addService()">

+ Adicionar Serviço

</button>

<div class="total-box">

<p>Total</p>

<h2 id="total">
R$ 0,00
</h2>

</div>

<input
type="hidden"
name="total"
id="input-total">

<button
type="submit"
name="salvar"
class="generate-btn">

Salvar Orçamento

</button>

</form>

</div>

<div class="preview">

<div class="preview-header">

<div>

<img
src="../assets/img/logo.png"
class="preview-logo">

<h1>Giordani Cleaning</h1>

<p>
(47) 99213-2615
</p>

<p>
(47) 99183-3664
</p>

<p>
Serviços de Limpeza,
Lavanderia e Manutenção
</p>

<p>
Atendimento em Balneário Piçarras,
Penha e Barra Velha
</p>

</div>

<img
src="../assets/img/caricatura.png"
width="220">

</div>

<h2>ORÇAMENTO</h2>

<table>

<thead>

<tr>

<th>Serviço</th>
<th>Descrição</th>
<th>Valor</th>

</tr>

</thead>

<tbody id="preview-services">

</tbody>

</table>

<div class="total-box">

<h2 id="preview-total">
R$ 0,00
</h2>

</div>

</div>

</div>

<script>

function addService(){

    let div =
    document.createElement('div');

    div.classList.add('service-item');

    div.innerHTML = `

    <select name="servico[]">

        <option>Faxina</option>
        <option>Lavanderia</option>
        <option>Airbnb</option>
        <option>Pós-obra</option>
        <option>Manutenção</option>

    </select>

    <input
    type="text"
    name="descricao[]"
    placeholder="Descrição">

    <input
    type="number"
    step="0.01"
    name="valor[]"
    placeholder="Valor"
    class="valor">

    <button
    type="button"
    class="remove-btn"
    onclick="this.parentElement.remove(); calcularTotal(); atualizarPreview();">

    X

    </button>

    `;

    document
    .getElementById('services-container')
    .appendChild(div);
}

document.addEventListener(
'input',
function(){

    calcularTotal();
    atualizarPreview();

});

function calcularTotal(){

    let total = 0;

    document
    .querySelectorAll('.valor')
    .forEach(input => {

        total += Number(input.value);

    });

    document
    .getElementById('input-total')
    .value = total;

    document
    .getElementById('total')
    .innerHTML =
    'R$ ' + total.toFixed(2);

    document
    .getElementById('preview-total')
    .innerHTML =
    'R$ ' + total.toFixed(2);
}

function atualizarPreview(){

    let preview =
    document.getElementById(
    'preview-services'
    );

    preview.innerHTML = '';

    document
    .querySelectorAll('.service-item')
    .forEach(item => {

        let servico =
        item.querySelector('select').value;

        let descricao =
        item.querySelector('input[type=text]').value;

        let valor =
        item.querySelector('.valor').value;

        preview.innerHTML += `

        <tr>

        <td>${servico}</td>

        <td>${descricao}</td>

        <td>
        R$ ${valor}
        </td>

        </tr>

        `;
    });
}

</script>

</body>
</html>