<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/conexao.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if($id <= 0){
    die("Registro inválido.");
}

if(isset($_POST['receber'])){

    $forma = SQLite3::escapeString($_POST['forma_pagamento']);
    $data = date('Y-m-d H:i:s');

    $db->exec("
        UPDATE historico_servicos
        SET
            status_pagamento='Recebido',
            forma_pagamento='$forma',
            data_recebimento='$data'
        WHERE id=$id
    ");

    header("Location: financeiro.php");
    exit;
}

$servico = $db->querySingle("
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

<title>Receber Pagamento</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.card{

background:#fff;

padding:30px;

border-radius:20px;

max-width:700px;

margin:auto;

box-shadow:0 3px 10px rgba(0,0,0,.08);

}

.info{

margin-bottom:18px;

font-size:17px;

color:#111827;

}

label{

display:block;

margin-top:18px;

margin-bottom:8px;

font-weight:bold;

color:#111827;

}

select{

width:100%;

padding:12px;

border:1px solid #ddd;

border-radius:10px;

font-size:15px;

}

button{

margin-top:25px;

padding:14px 22px;

background:#16a34a;

color:white;

border:none;

border-radius:10px;

cursor:pointer;

font-size:16px;

font-weight:bold;

}

button:hover{

background:#15803d;

}

.voltar{

display:inline-block;

margin-left:10px;

padding:14px 22px;

background:#64748b;

color:white;

border-radius:10px;

text-decoration:none;

font-weight:bold;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Receber Pagamento</h1>

</div>

<div class="card">

<div class="info">
<b>Cliente:</b>
<?= htmlspecialchars($servico['cliente']); ?>
</div>

<div class="info">
<b>Funcionário:</b>
<?= htmlspecialchars($servico['funcionario_nome']); ?>
</div>

<div class="info">
<b>Serviço:</b>
<?= htmlspecialchars($servico['servico']); ?>
</div>

<div class="info">
<b>Valor:</b>
<strong>R$ <?= number_format($servico['valor'],2,',','.'); ?></strong>
</div>

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $servico['id']; ?>">

<label>Forma de Pagamento</label>

<select name="forma_pagamento" required>

<option value="">Selecione...</option>

<option value="PIX">PIX</option>

<option value="Dinheiro">Dinheiro</option>

<option value="Cartão Crédito">Cartão Crédito</option>

<option value="Cartão Débito">Cartão Débito</option>

<option value="Transferência">Transferência</option>

<option value="Boleto">Boleto</option>

</select>

<button
type="submit"
name="receber">

✅ Confirmar Recebimento

</button>

<a
href="financeiro.php"
class="voltar">

Cancelar

</a>

</form>

</div>

</div>

</body>

</html>