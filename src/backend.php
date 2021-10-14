<?php    
    function exibirMenu(){
        echo "<div class=\"logo\">";
        echo "<figure>";
        echo "<img src=\"../img/logo.png\" alt=\"Logo da Página\"/>";
        echo "</figure>";
        echo "</div>";
        if(isset ($_SESSION['user'])){
            echo "<nav class=\"menu\">";
            echo "<ul>";
            echo "<li><a target=\"_self\" href=\"tetris.php\" target=\"content\">Tetris</a></li>";
            echo "<li>";
            echo "<div class=\"dropdown\">";
            echo "<button class=\"dropbtn\">Ranking</button>";
            echo "<div class=\"dropdown-content\">";
            echo "<a target=\"_self\" href=\"ranking_pessoal.php\" target=\"content\">Ranking Pessoal</a>";
            echo "<a target=\"_self\" href=\"ranking_global.php\" target=\"content\">Ranking Global</a>";
            echo "</div>";
            echo "</div>";
            echo "</li>";

            echo "<li>";
            echo "<div class=\"dropdown\">";
            echo "<button class=\"dropbtn\"><img src=\"../img/avatar/".$_SESSION['avatar']."\" alt=\"Avatar\"/><br>".$_SESSION['user']."</button>";
            echo "<div class=\"dropdown-content\">";
            echo "<a target=\"_self\" href=\"perfil.php\" target=\"content\">Alterar Dados</a>";
            echo "<a target=\"_self\" href=\"sair.php\" target=\"content\">Sair</a>";
            echo "</div>";
            echo "</div>";
            echo "</li>";
            echo "</ul>";
            echo "</nav>";
        }
    }

    function exibirFooter(){
        echo "<p>Tetris © 2020, All Rights Reserved</p>";
    }

    function conectar(){
        $sname = "localhost";
        $uname = "root";
        $pwd = "carolLinda";
        try {
            $conn = new PDO("mysql:host=$sname; dbname=dbtetris", $uname, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function cadastrar(){
        $nome = $_POST['nome'];
        $dt_nasc = $_POST['dt_nasc'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $senha = $_POST['senha'];
        $avatar = $_POST['avatar'];

        if($nome == "" || $dt_nasc == "" || $cpf == "" || $telefone == "" || $email == "" || $user == "" || $senha == "" || $avatar == ""){
            echo "Todos os campos devem ser preenchidos.";
        }
        else {
            try{
                $conexao = conectar();
                $resultCPF = $conexao->prepare("SELECT cpf FROM Usuario WHERE cpf=?");
                $resultCPF->execute([$cpf]);
                $rowCPF = $resultCPF->fetch();

                $resultUser = $conexao->prepare("SELECT nome_usuario FROM Usuario WHERE nome_usuario=?");
                $resultUser->execute([$user]);
                $rowUser = $resultUser->fetch();

                if(!$rowCPF){
                    if($rowUser[0] == $user){
                        echo "O nome de usuário '".$user."' já existe.";
                    }
                    else {
                        $resultCPF = $conexao->prepare("INSERT INTO Usuario VALUES (?,?,?,?,?,?,?,?)");
                        $resultCPF->execute([$cpf, $nome, $dt_nasc, $telefone, $email, $user, $senha, $avatar]);
                        $_SESSION['user'] = $user;
                        $_SESSION['cpf'] = $cpf;
                        $_SESSION['avatar'] = $avatar;
                        if($resultCPF->rowCount() < 0){
                            echo "Não foi possível cadastrar o usuário.";
                        }
                        else {
                            header('location:tetris.php');
                        }
                    }
                }
                else
                    echo "Usuário já cadastrado.";

            }
            catch(PDOException $e){
                echo "Ocorreu um erro: " . $e->getMessage();
            }
        }
    }

    function logar(){
        $login = $_POST['user'];
        $senha = $_POST['senha'];

        if($login == "" || $senha == ""){
            echo "Todos os campos devem ser preenchidos.";
        }
        else {
            $conexao = conectar();
            $result = $conexao->prepare("SELECT cpf, avatar FROM Usuario WHERE nome_usuario=? AND senha=?");
            $result->execute([$login, $senha]);
            $row = $result->fetch();

            if($row){
                $_SESSION['user'] = $login;
                $_SESSION['cpf'] = $row[0];
                $_SESSION['avatar'] = $row[1];
                header("location: tetris.php");
            }
            else
                echo "Os dados inseridos estão incorretos.";
        }
    }

    function inserirJogada($pontuacao,$nivel,$tempo){
        try{
            $conexao = conectar();
            $result = $conexao->prepare("INSERT INTO Jogada (nome_usuario,pontuacao,nivel,tempo) VALUES (?,?,?,?)");
            $result->execute([$_SESSION['user'],$pontuacao,$nivel,$tempo]);
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }

    function exibirRankingGlobal(){
        try{
            $conexao = conectar();
            $result = $conexao->query("SELECT * FROM Jogada ORDER BY pontuacao DESC LIMIT 10");
            echo "<table>";
            echo "<tr>";
            echo "<th>POSIÇÃO</th>";
            echo "<th>JOGADOR</th>";
            echo "<th>PONTUAÇÃO</th>";
            echo "<th>NÍVEL</th>";
            echo "</tr>";
            $posicao = 1;
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                echo "<td>".$posicao."º</td>";
                echo "<td>".$row['nome_usuario']."</td>";
                echo "<td>".$row['pontuacao']."</td>";
                echo "<td>".$row['nivel']."</td>";
                echo "</tr>";
                $posicao++;
            }
            echo "</table>";
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }

    function exibirRankingPessoal(){
        try{
            $conexao = conectar();
            $stmt = $conexao->prepare("SELECT * FROM Jogada WHERE nome_usuario = ? ORDER BY pontuacao DESC");
            $stmt->execute([$_SESSION['user']]);
            echo "<table>";
            echo "<tr>";
            echo "<th>POSIÇÃO</th>";
            echo "<th>PONTUAÇÃO</th>";
            echo "<th>NÍVEL</th>";
            echo "<th>TEMPO (s)</th>";
            echo "</tr>";
            $posicao = 1;
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>".$posicao."</td>";
                echo "<td>".$row['pontuacao']."</td>";
                echo "<td>".$row['nivel']."</td>";
                echo "<td>".$row['tempo']."</td>";
                echo "</tr>";
                $posicao++;
            }
            echo "</table>";
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }

    function exibirSuaPosicao(){
        try{
            $conexao = conectar();
            $stmt = $conexao->query("SELECT * FROM Jogada ORDER BY pontuacao DESC");
            $posicao = 1;
            while ($row = $stmt->fetch()) {
                if($row['nome_usuario'] == $_SESSION['user']){
                    echo $posicao."º";
                    break;
                }
                $posicao++;
            }
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }

    function getDadosUsuario(){
        try{
            $conexao = conectar();
            $stmt = $conexao->prepare("SELECT nome_completo, telefone, email, senha FROM Usuario WHERE nome_usuario=?");
            $stmt->execute([$_SESSION['user']]);
            $row = $stmt->fetch();
            return $row;
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }
    function alterarCadastro($nomeAntigo,$telefoneAntigo,$emailAntigo,$senhaAntiga){
        $novoNome = $_POST['nome'];
        $novoTelefone = $_POST['telefone'];
        $novoEmail = $_POST['email'];
        $novaSenha = $_POST['senha'];
        if($novoNome == ""){
            $novoNome = $nomeAntigo;
        }
        if($novoTelefone == ""){
            $novoTelefone = $telefoneAntigo;
        }
        if($novoEmail == ""){
            $novoEmail = $emailAntigo;
        }
        if($novaSenha == ""){
            $novaSenha = $senhaAntiga;
        }
        try{
            $conexao = conectar();
            $stmt = $conexao->prepare("UPDATE Usuario SET nome_completo=?, telefone=?, email=?, senha=? WHERE nome_usuario=? AND cpf=?");
            $stmt->execute([$novoNome, $novoTelefone, $novoEmail, $novaSenha, $_SESSION['user'], $_SESSION['cpf']]);
            if($stmt->rowCount()>0){
                echo "Alteração concluída!";
            }else{
                if($stmt->rowCount()<=0){
                    echo "Não foi possível realizar a alteração.";
                }
            }
        }
        catch(PDOException $e){
            echo "Ocorreu um erro: " . $e->getMessage();
        }
    }
?>
