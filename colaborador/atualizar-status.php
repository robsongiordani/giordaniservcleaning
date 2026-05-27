<?php
include '../auth.php';
include '../config/conexao.php';

$id = $_GET['id'];

$sql = "UPDATE servicos
SET status = 'Concluído'
WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();

header('Location: dashboard.php');
?>