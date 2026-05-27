<?php
session_start();

$erro = '';
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

<?php if(isset($erro)) { ?>

<p><?php echo $erro; ?></p>

<?php } ?>

<input
type="email"
name="email"
placeholder="E-mail"
required>

<input
type="password"
name="senha"
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