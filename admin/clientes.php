<?php
include '../auth.php';
include '../config/conexao.php';

if(isset($_POST['salvar'])){

 $nome = $_POST['nome'];
 $telefone = $_POST['telefone'];
 $endereco = $_POST['endereco'];

 $sql = "INSERT INTO clientes(nome, telefone, endereco)
 VALUES(?,?,?)";

 $stmt = $conn->prepare($sql);
 $stmt->bind_param('sss', $nome, $telefone, $endereco);
 $stmt->execute();
}
?>

<form method="POST">
<input type="text" name="nome" placeholder="Nome">
<input type="text" name="telefone" placeholder="Telefone">
<input type="text" name="endereco" placeholder="Endereço">
<button name="salvar">Salvar</button>
</form>