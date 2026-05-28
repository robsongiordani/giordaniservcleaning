<?php

$db = new SQLite3(__DIR__ . '/cleanmanager.db');

$db->exec("CREATE TABLE IF NOT EXISTS clientes (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    nome TEXT,
    telefone TEXT,
    endereco TEXT,
    observacoes TEXT

)");

echo "Tabela clientes criada!<br>";

$db->exec("CREATE TABLE IF NOT EXISTS servicos (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    cliente_id INTEGER,

    tipo TEXT,

    valor REAL,

    data TEXT,

    colaborador TEXT,

    status TEXT

)");

echo "Tabela servicos criada!";