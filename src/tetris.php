<!--HOME-->
<!DOCTYPE html>
<html lang="pt">
    <head>
		<meta charset="utf-8"/>
        <title>Tetris</title>
        <script src="funcoes.js"></script>
        <script src="pecas.js"></script>
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
        <section class="main" id="main">
                <div class="form_content" id="form_content">
                    <h2 id="TITULO">ROLLING TETRIS</h2>
                    <hr/>
                    <form class="tamanho_tabuleiro" id="tabuleiro">
                        <h3>Tamanho do Tabuleiro</h3>
                            <input type="radio" id="pequeno" value="pequeno" name="tamanho">
                            <label class="label_opcao_tamanho" for="pequeno">20 x 10</label>

                            <input type="radio" id="grande" value="grande" name="tamanho">
                            <label class="label_opcao_tamanho" for="grande">22 x 44</label><br/>
                        <button type="button" onclick="inicializarTabuleiro();">Iniciar Partida</button>
                    </form>
                </div>

                <div id="dados_partida">
                    <table id="table_dados_partida">
                        <tr>
                            <td><h3>Pontuação: </h3></td>
                            <td><span id="pontuacao">0</span></td>
                        </tr>
                        <tr>
                            <td><h3>Nível: </h3></td>
                            <td><span id="nivel">1</span></td>
                        </tr>
                        <tr>
                            <td><h3>Linhas Eliminadas: </h3></td>
                            <td><span id="linhase">0</span></td>
                        </tr>
                         <tr>
                            <td><h3>Tempo: </h3></td>
                            <td><span id="tempo">0</span></td>
                        </tr>
                    </table>
                </div>

                <div id="canvas_jogo">
                    <canvas id="jogo"></canvas>
                </div>
        </section>

        <footer class="footer">
            <?php
                exibirFooter();
            ?>
        </footer>
    </body>
</html>
