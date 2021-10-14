<?php
    session_start();
    include ("backend.php");

    $pontuacao = $_POST['pontuacao'];
    $nivel = $_POST['nivel'];
    $tempo = $_POST['segundos'];
    $linhas = $_POST['linhas'];

    inserirJogada($pontuacao,$nivel,$tempo);
?>
