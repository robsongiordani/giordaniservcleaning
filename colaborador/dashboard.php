<?php
include '../auth.php';
include '../config/conexao.php';

$id = $_SESSION['id'];

$sql = "SELECT * FROM servicos WHERE colaborador_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1>Minhas Tarefas</h1>

<?php while($servico = $result->fetch_assoc()) { ?>

<div>
<p><?php echo $servico['tipo_servico']; ?></p>
<p>R$ <?php echo $servico['valor']; ?></p>
<p><?php echo $servico['status']; ?></p>
</div>

<?php } ?>