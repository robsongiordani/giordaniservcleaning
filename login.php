<?php
session_start();

if(isset($_POST['login'])){

    $_SESSION['usuario'] = 'Robson';
    $_SESSION['tipo'] = 'admin';
    $_SESSION['id'] = 1;

    header('Location: admin/dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link rel="stylesheet"
href="assets/css/login.css">

</head>

<body>

<form method="POST" class="login-box">

<h1>CleanManager</h1>

<input
type="email"
placeholder="E-mail"
required>

<input
type="password"
placeholder="Senha"
required>

<button
type="submit"
name="login">

Entrar

</button>

</form>

</body>
</html>