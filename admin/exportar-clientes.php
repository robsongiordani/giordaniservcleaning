<?php

$db = new SQLite3(
__DIR__ . '/../database/cleanmanager.db'
);

header('Content-Type: text/csv');

header(
'Content-Disposition:
attachment;
filename="clientes.csv"'
);

$output = fopen('php://output', 'w');

fputcsv(
$output,
['Nome','Telefone','Endereço']
);

$result = $db->query(
"SELECT * FROM clientes"
);

while($cliente = $result->fetchArray()){

    fputcsv($output,[

        $cliente['nome'],
        $cliente['telefone'],
        $cliente['endereco']

    ]);
}

fclose($output);