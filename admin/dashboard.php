<?php
include '../auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="sidebar">
<h2>Admin</h2>

<a href="dashboard.php">Dashboard</a>
<a href="clientes.php">Clientes</a>
<a href="servicos.php">Serviços</a>
<a href="colaboradores.php">Colaboradores</a>
<a href="../logout.php">Sair</a>
</div>

<div class="content">

<div class="card">
<h1>Painel Administrativo</h1>
<p>Bem-vindo <?php echo $_SESSION['usuario']; ?></p>
</div>

<div class="card">
<h2>Total Mensal</h2>
<h1>R$ 8.500</h1>
</div>

</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>