<?php

$db = new SQLite3(__DIR__ . '/cleanmanager.db');

$db->exec("CREATE TABLE IF NOT EXISTS clientes (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    nome TEXT,
    telefone TEXT,
    endereco TEXT,
    observacoes TEXT

)");

echo "Tabela clientes criada!";