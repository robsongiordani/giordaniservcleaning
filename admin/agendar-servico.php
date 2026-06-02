<?php

include '../config/conexao.php';

$id = $_GET['id'];

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '$id'

", true);

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '$id'

");

$lista = '';

while($item = $itens->fetchArray()){

    $lista .=
    $item['servico'] .
    ', ';
}

if($_POST){

    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $observacoes = $_POST['observacoes'];
    $osNumero = 'OS-' . str_pad($id, 5, '0', STR_PAD_LEFT);

    $db->exec("

   INSERT INTO agenda
(
    os_numero,
    orcamento_id,
    cliente,
    telefone,
    servicos,
    data,
    horario,
    observacoes,
    status
)

   VALUES
(
    '$osNumero',
    '$id',
        '".$orcamento['nome']."',
        '".$orcamento['telefone']."',
        '".$lista."',
        '$data',
        '$horario',
        '$observacoes',
        'Agendado'
    )

    ");

    $db->exec("

    UPDATE orcamentos

    SET status = 'Aprovado'

    WHERE id = '$id'

    ");

    header('Location: agenda.php');

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Agendar Serviço</title>

<link rel="stylesheet"
href="../assets/css/dashboard.css">

<style>

.form-box{

    background:white;

    padding:30px;

    border-radius:20px;

    max-width:700px;
}

.form-box h2{

    margin-bottom:20px;

    color:#1e3a8a;
}

.form-box input,
.form-box textarea{

    width:100%;

    padding:14px;

    margin-bottom:20px;

    border-radius:12px;

    border:1px solid #ddd;
}

.form-box button{

    background:#2563eb;

    color:white;

    border:none;

    padding:14px 22px;

    border-radius:12px;

    font-weight:bold;

    cursor:pointer;
}

.info{

    margin-bottom:20px;

    line-height:1.8;
}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Agendar Serviço</h1>

</div>

<div class="form-box">

<h2>

<?= $orcamento['nome']; ?>

</h2>

<div class="info">

<p>

<strong>Telefone:</strong>

<?= $orcamento['telefone']; ?>

</p>

<p>

<strong>Serviços:</strong>

<?= $lista; ?>

</p>

</div>

<form method="POST">

<label>Data do Serviço</label>

<input
type="date"
name="data"
required>

<label>Horário</label>

<input
type="time"
name="horario"
required>

<label>Observações</label>

<textarea
name="observacoes"
rows="5"></textarea>

<button>

Confirmar Agendamento

</button>

</form>

</div>

</div>

</body>
</html>