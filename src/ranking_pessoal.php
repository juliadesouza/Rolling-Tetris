<!--RANKING-->
<!DOCTYPE html>
<html lang="pt">
    <head>
		<meta charset="utf-8">
		<title>Ranking Pessoal</title>
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

		<section class="main">
			<div class="form_content">
				<h2>SEU RANKING</h2>
				<hr/>
				<?php
					exibirRankingPessoal();
				?>
			</div>
		</section>

		<footer class="footer_scroll">
            <?php
                exibirFooter();
            ?>
        </footer>
    </body>
</html>
