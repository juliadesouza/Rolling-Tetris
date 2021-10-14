<!--PÁGINA PARA ALTERAÇÃO DE DADOS-->
<!DOCTYPE html>
<htmL lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Perfil</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body class="grid_container">
        <?php
            session_start();
            include ("backend.php");
            if(!isset($_SESSION['user'])){
                header('location:login.php');
            }
        ?>
        <header class="header">
            <?php
                exibirMenu();
            ?>
        </header>

        <<section class="main">
            <div class="form_content">
                <h2>Perfil</h2>
                <hr/>
                <p id="mensagem">
                    <?php 
                        $row = getDadosUsuario();
                        $nomeAntigo = $row[0];
                        $telefoneAntigo = $row[1];
                        $emailAntigo = $row[2];
                        $senhaAntiga = $row[3];
                        if(isset($_POST['alterar'])){
                            alterarCadastro($nomeAntigo,$telefoneAntigo,$emailAntigo,$senhaAntiga);
                        }
                    ?>
                </p>
                <form method="POST" action="perfil.php">
                    <label class="label">Nome Completo: <?php echo $nomeAntigo; ?></label><br/>
                    <input type="text" placeholder="Digite o novo nome" name="nome"/><br/>

                    <label class="label">Telefone:  <?php echo $telefoneAntigo; ?></label><br/>
                    <input type="tel" placeholder="Digite o novo telefone" name="telefone" pattern="\([0-9]{2}\)[\s][0-9]{5}-[0-9]{4}"/><br/>

                    <label class="label">E-mail: <?php echo $emailAntigo; ?> </label><br/>
                    <input type="email" placeholder="Digite o novo email" name="email"/><br/>

                    <label class="label">Senha<?php $senhaAntiga; ?></label><br/>
                    <input type="password" placeholder="Digite a nova senha" name="senha" minlength="8" maxlength="30" /><br/>
                    
                    <input type="submit" value="Alterar" id="alterar" name="alterar">
                </form>
            </div>
        </section>

        <footer class="footer_scroll">
            <?php
                exibirFooter();
            ?>
        </footer>
    </body>
</html>
