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

    data TEXT

)");

echo "Tabela servicos criada!<br>";

$db->exec("CREATE TABLE IF NOT EXISTS ordens (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    cliente_id INTEGER,

    data TEXT,

    status TEXT,

    observacoes TEXT,

    total REAL

)");

$db->exec("CREATE TABLE IF NOT EXISTS itens_ordem (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    ordem_id INTEGER,

    servico TEXT,

    descricao TEXT,

    valor REAL

)");

echo "Tabela ordens criada!";
$db->exec("CREATE TABLE IF NOT EXISTS orcamentos (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    cliente_id INTEGER,

    observacoes TEXT,

    total REAL,

    status TEXT,

    data TEXT

)");

$db->exec("CREATE TABLE IF NOT EXISTS itens_orcamento (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    orcamento_id INTEGER,

    servico TEXT,

    descricao TEXT,

    valor REAL

)");

$db->exec("CREATE TABLE IF NOT EXISTS agenda (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    cliente TEXT,

    telefone TEXT,

    servicos TEXT,

    data TEXT,

    horario TEXT,

    observacoes TEXT,

    status TEXT

)");
$db->exec("CREATE TABLE IF NOT EXISTS historico_financeiro (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    cliente TEXT,

    telefone TEXT,

    servico TEXT,

    valor REAL,

    data TEXT

)");