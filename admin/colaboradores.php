<?php
include '../auth.php';
include '../config/conexao.php';

if(isset($_POST['criar'])){

 $nome = $_POST['nome'];
 $email = $_POST['email'];
 $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

 $sql = "INSERT INTO usuarios(nome,email,senha,tipo)
 VALUES(?,?,?,'colaborador')";

 $stmt = $conn->prepare($sql);
 $stmt->bind_param('sss', $nome, $email, $senha);
 $stmt->execute();
}
?>

<form method="POST">
<input type="text" name="nome" placeholder="Nome">
<input type="email" name="email" placeholder="E-mail">
<input type="password" name="senha" placeholder="Senha">
<button name="criar">Criar Colaborador</button>
</form>