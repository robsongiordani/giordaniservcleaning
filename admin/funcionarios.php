<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../auth.php';

$db = new SQLite3(__DIR__.'/../database/cleanmanager.db');

if(isset($_GET['excluir'])){

    $id=(int)$_GET['excluir'];

    $db->exec("DELETE FROM funcionarios WHERE id=$id");

    header("Location: funcionarios.php");
    exit;

}

if(isset($_POST['salvar'])){

    $nome=$_POST['nome'];
    $cpf=$_POST['cpf'];
    $telefone=$_POST['telefone'];
    $email=$_POST['email'];
    $endereco=$_POST['endereco'];
    $cargo=$_POST['cargo'];
    $usuario=$_POST['usuario'];
    $senha=password_hash($_POST['senha'],PASSWORD_DEFAULT);
    $nivel=$_POST['nivel'];

    $stmt=$db->prepare("

        INSERT INTO funcionarios
        (
            nome,
            cpf,
            telefone,
            email,
            endereco,
            cargo,
            usuario,
            senha,
            nivel
        )

        VALUES
        (
            :nome,
            :cpf,
            :telefone,
            :email,
            :endereco,
            :cargo,
            :usuario,
            :senha,
            :nivel
        )

    ");

    $stmt->bindValue(':nome',$nome);
    $stmt->bindValue(':cpf',$cpf);
    $stmt->bindValue(':telefone',$telefone);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':endereco',$endereco);
    $stmt->bindValue(':cargo',$cargo);
    $stmt->bindValue(':usuario',$usuario);
    $stmt->bindValue(':senha',$senha);
    $stmt->bindValue(':nivel',$nivel);

    $stmt->execute();

    header("Location: funcionarios.php");
    exit;

}

$result=$db->query("SELECT * FROM funcionarios ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Funcionários</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>

.card{

background:white;

padding:25px;

border-radius:20px;

margin-bottom:25px;

}

input,
select{

width:100%;

padding:12px;

margin-bottom:15px;

border:1px solid #ddd;

border-radius:10px;

}

button{

background:#2563eb;

color:white;

border:none;

padding:12px 20px;

border-radius:10px;

cursor:pointer;

font-weight:bold;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

background:white;

}

th{

background:#2563eb;

color:white;

padding:12px;

}

td{

padding:12px;

border:1px solid #ddd;

background:white;

color:#111827;

}

tr:nth-child(even){

background:#f8fafc;

}

tr:hover{

background:#eef4ff;

}

.excluir{

background:#dc2626;

color:white;

padding:8px 12px;

border-radius:8px;

text-decoration:none;

}

</style>

</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="content">

<div class="topbar">

<h1>Funcionários</h1>

</div>

<div class="card">

<h2>Novo Funcionário</h2>

<form method="POST">

<input
type="text"
name="nome"
placeholder="Nome"
required>

<input
type="text"
name="cpf"
placeholder="CPF">

<input
type="text"
name="telefone"
placeholder="Telefone">

<input
type="email"
name="email"
placeholder="E-mail">

<input
type="text"
name="endereco"
placeholder="Endereço">

<input
type="text"
name="cargo"
placeholder="Cargo">

<input
type="text"
name="usuario"
placeholder="Usuário"
required>

<input
type="password"
name="senha"
placeholder="Senha"
required>

<select name="nivel">

<option>Funcionário</option>

<option>Supervisor</option>

<option>Administrador</option>

</select>

<button
type="submit"
name="salvar">

Cadastrar Funcionário

</button>

</form>

</div>

<div class="card">

<h2>Funcionários Cadastrados</h2>

<table>

<tr>

<th>Nome</th>

<th>Cargo</th>

<th>Telefone</th>

<th>Usuário</th>

<th>Nível</th>

<th>Ação</th>

</tr>

<?php while($f=$result->fetchArray()){ ?>

<tr>

<td><?= htmlspecialchars($f['nome']) ?></td>

<td><?= htmlspecialchars($f['cargo']) ?></td>

<td><?= htmlspecialchars($f['telefone']) ?></td>

<td><?= htmlspecialchars($f['usuario']) ?></td>

<td><?= htmlspecialchars($f['nivel']) ?></td>

<td>

<a
class="excluir"
href="?excluir=<?= $f['id'] ?>"
onclick="return confirm('Excluir funcionário?')">

Excluir

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>