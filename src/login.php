<!--LOGIN-->
<!DOCTYPE html>
<htmL lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
                <h2>Login</h2>
                <hr/>
                <p id="mensagem">
                    <?php
                        if(isset($_POST['logar'])){
                            logar();
                        }
                    ?>
                </p>
                <form method="POST" action="login.php">
                    <label class="label">Usuário</label><br/>
                    <input type="text" placeholder="Digite seu usuário" name="user" id="user"/><br/>
                    <label class="label">Senha</label><br/>
                    <input type="password" placeholder="Digite sua senha" name="senha" /><br/>
                    <input type="submit" value="Logar" id="Logar" name="logar">
                    <p class="label">Ainda não possui cadastro? <a href="cadastro.php">Cadastre-se</a></p>
                </form>
            </div>
        </section>

        <footer class="footer">
            <?php
                exibirFooter();
            ?>
        </footer>
    </body>
</html>
