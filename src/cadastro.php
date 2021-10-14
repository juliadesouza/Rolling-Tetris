<!--CADASTRO-->
<!DOCTYPE html>
<htmL lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    <body class="grid_container">
        <?php
            session_start();
            include ("backend.php");
            if(isset($_SESSION["user"])){
                header("location: tetris.php");
            }
        ?>
        <header class="header">
            <?php
                exibirMenu();
            ?>
        </header>

        <section class="main">
            <div class="form_content">
                <h2>Cadastro</h2>
                <hr/>
                <p id="mensagem">
                    <?php
                        if(isset($_POST['cadastrar'])){
                            cadastrar();
                        }
                    ?>
                </p>
                <form method="POST" action ="cadastro.php">
                    <fieldset class="dados_pessoais">
                        <label class="label">Nome Completo</label><br/>
                        <input type="text" placeholder="Digite seu nome" name="nome" required/><br/>

                        <label class="label">Data de Nascimento</label><br/>
                        <input type="date" name="dt_nasc" required/><br/>

                        <label class="label">CPF</label><br/>
                        <input type="text" placeholder="Digite seu CPF" name="cpf" minlength="11" maxlength="11" pattern="[0-9]+" required/><br/>

                        <label class="label">Telefone</label><br/>
                        <input type="tel" placeholder="Digite seu telefone" name="telefone" pattern="\([0-9]{2}\)[\s][0-9]{5}-[0-9]{4}" required/><br/>

                        <label class="label">E-mail</label><br/>
                        <input type="email" placeholder="Digite seu email" name="email" required/><br/>
                    </fieldset>

                    <fieldset class="dados_user">
                        <label class="label">Usuário</label><br/>
                        <input type="text" placeholder="Digite seu usuário" name="user" required/><br/>

                        <label class="label">Senha</label><br/>
                        <input type="password" placeholder="Digite sua senha" name="senha" minlength="8" maxlength="30" required/><br/>

                        <label class="label">Avatar</label><br/>
                            <input type="radio" id="pinguim" name="avatar" value="penguin.png" required>
                            <label class="label_avatar" for="pinguim"><img src="../img/avatar/penguin.png" alt="Avatar-Pinguim"></label>

                            <input type="radio" id="elefante" name="avatar" value="elephant.png">
                            <label class="label_avatar" for="elefante"><img src="../img/avatar/elephant.png" alt="Avatar-Elefante"></label>

                            <input type="radio" id="pintinho" name="avatar" value="chick.png">
                            <label class="label_avatar" for="pintinho"><img src="../img/avatar/chick.png" alt="Avatar-Pintinho"></label><br/>

                            <input type="radio" id="vaca" name="avatar" value="cow.png">
                            <label class="label_avatar" for="vaca"><img src="../img/avatar/cow.png" alt="Avatar-Vaca"></label>

                            <input type="radio" id="panda" name="avatar"  value="panda.png">
                            <label class="label_avatar" for="panda"><img src="../img/avatar/panda.png" alt="Avatar-Panda"></label>

                            <input type="radio" id="polvo" name="avatar" value="octopus.png">
                            <label class="label_avatar" for="polvo"><img src="../img/avatar/octopus.png" alt="Avatar-Polvo"></label><br/>
                        <input type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
                    </fieldset>
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
