<?php
include '../auth.php';
include '../config/conexao.php';

if(isset($_POST['salvar'])){

 $cliente = $_POST['cliente'];
 $colaborador = $_POST['colaborador'];
 $tipo = $_POST['tipo'];
 $valor = $_POST['valor'];
 $data = $_POST['data'];

 $sql = "INSERT INTO servicos
 (cliente_id,colaborador_id,tipo_servico,valor,data_servico,status)
 VALUES(?,?,?,?,?,'Pendente')";

 $stmt = $conn->prepare($sql);
 $stmt->bind_param('iisds',
 $cliente,
 $colaborador,
 $tipo,
 $valor,
 $data
 );

 $stmt->execute();
}
?>