<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../auth.php';

$db = new SQLite3(__DIR__ . '/../database/cleanmanager.db');

if(isset($_GET['excluir'])){

    $id = $_GET['excluir'];

    $db->exec(
    "DELETE FROM clientes
    WHERE id = $id"
    );
}

if(isset($_POST['salvar'])){

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $tipo_servico = $_POST['tipo_servico'];
    $origem = $_POST['origem'];
    $observacoes = $_POST['observacoes'];

    $sql = "

    INSERT INTO clientes
    (
        nome,
        telefone,
        endereco,
        cpf_cnpj,
        cidade,
        tipo_servico,
        origem,
        observacoes
    )

    VALUES
    (
        '$nome',
        '$telefone',
        '$endereco',
        '$cpf_cnpj',
        '$cidade',
        '$tipo_servico',
        '$origem',
        '$observacoes'
    )

    ";

    $db->exec($sql);
}
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

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Clientes</h1>

</div>

<div class="card">

<h2>Novo Cliente</h2>

<form method="POST">

<div class="input-group">

<label>Nome</label>

<input
type="text"
name="nome"
placeholder="Nome do cliente"
required>

</div>

<div class="input-group">

<label>Telefone</label>

<input
type="text"
name="telefone"
placeholder="Telefone">

</div>

<div class="input-group">

<label>CPF / CNPJ</label>

<input
type="text"
name="cpf_cnpj"
placeholder="CPF ou CNPJ">

</div>

<div class="input-group">

<label>Cidade</label>

<input
type="text"
name="cidade"
placeholder="Cidade">

</div>

<div class="input-group">

<label>Tipo de Serviço</label>

<select name="tipo_servico">

<option value="">Selecione</option>

<option>Limpeza Residencial</option>
<option>Limpeza Comercial</option>
<option>Condomínio</option>
<option>Zeladoria</option>
<option>Lavanderia</option>
<option>Pequenas Manutenções</option>

</select>

</div>

<div class="input-group">

<label>Origem do Cliente</label>

<select name="origem">

<option value="">Selecione</option>

<option>Google</option>
<option>Instagram</option>
<option>WhatsApp</option>
<option>Site</option>
<option>Indicação</option>
<option>Panfleto</option>
<option>Outro</option>

</select>

</div>

<div class="input-group">

<label>Endereço</label>

<input
type="text"
name="endereco"
placeholder="Endereço">

</div>

<div class="input-group">

<label>Observações</label>

<input
type="text"
name="observacoes"
placeholder="Observações">

</div>

<button
type="submit"
name="salvar">

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
<th>Cidade</th>
<th>Serviço</th>
<th>Origem</th>
<th>Endereço</th>
<th>Ações</th>

</tr>

<?php

$result = $db->query(
"SELECT * FROM clientes ORDER BY id DESC"
);

while($cliente = $result->fetchArray()){

?>

<tr>

<td>
<?= $cliente['nome']; ?>
</td>

<td>
<?= $cliente['telefone']; ?>
</td>

<td>
<?= $cliente['cidade']; ?>
</td>

<td>
<?= $cliente['tipo_servico']; ?>
</td>

<td>
<?= $cliente['origem']; ?>
</td>

<td>
<?= $cliente['endereco']; ?>
</td>

<td class="actions">

<a
href="perfil-cliente.php?id=<?= $cliente['id']; ?>"
class="view-btn">

Ver Perfil

</a>

<a
href="clientes.php?excluir=<?= $cliente['id']; ?>"
class="delete-btn">

Excluir

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>