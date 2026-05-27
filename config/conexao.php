<?php

$conn = new mysqli(
    'localhost',
    'root',
    '',
    'cleanmanager'
);

if($conn->connect_error){
    die('Erro conexão');
}
?>