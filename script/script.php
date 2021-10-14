<?php
    $sname = "localhost";
    $uname = "root";
    $pwd = "carolLinda";
    try {
        $conn = new PDO("mysql:host=$sname; dbname=dbtetris", $uname, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlUsuario = "CREATE TABLE Usuario(
                        cpf CHAR(11) PRIMARY KEY,
                        nome_completo VARCHAR(200) NOT NULL,
                        data_nascimento DATE NOT NULL,
                        telefone CHAR(15) NOT NULL,
                        email VARCHAR(200) NOT NULL,
                        nome_usuario VARCHAR(20) NOT NULL,
                        senha VARCHAR(30) NOT NULL,
                        avatar VARCHAR(100) NOT NULL,
                        UNIQUE (nome_usuario)
                    )";
        $sqlJogada = "CREATE TABLE Jogada(
                        codigo INT AUTO_INCREMENT PRIMARY KEY,
                        nome_usuario VARCHAR(20),
                        pontuacao INT NOT NULL,
                        nivel INT NOT NULL,
                        tempo INT NOT NULL,
                        FOREIGN KEY (nome_usuario) REFERENCES Usuario(nome_usuario)
                    )";
        $conn->exec($sqlUsuario);
        $conn->exec($sqlJogada);
        echo "Tabela Usuario criada com sucesso!<br>";
        echo "Tabela Jogada criada com sucesso!<br>";
        return $conn;
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>