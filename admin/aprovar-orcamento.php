<?php

include '../config/conexao.php';

$id = $_GET['id'];

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '$id'

", true);

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '$id'

");

$lista = '';

while($item = $itens->fetchArray()){

    $lista .=
    $item['servico'] .
    ' - ';
}

$db->exec("

UPDATE orcamentos

SET status = 'Aprovado'

WHERE id = '$id'

");

$db->exec("

INSERT INTO agenda
(
    cliente,
    telefone,
    servicos,
    data,
    status
)

VALUES
(
    '".$orcamento['nome']."',
    '".$orcamento['telefone']."',
    '".$lista."',
    '".$orcamento['data']."',
    'Pendente'
)

");

header('Location: orcamentos.php');

?>