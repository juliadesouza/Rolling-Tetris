document.addEventListener("DOMContentLoaded", () =>{
    /* ----- Constantes ----- */
    const xi = 4;  /* Posicão x inicial de cada peça do jogo */
    const tam_quadrado = 20; /* Tamanho de cada quadradinho desenhado no canvas */
    const cor_fundo ="#111111";
    const cor_especial= "#be00fe";
    const canvas = document.getElementById("jogo");
    const contexto = canvas.getContext("2d");

    /* Tipos de peças do nosso jogo */
    const tetraminos = [
        tetraminoI, tetraminoO, tetraminoT, tetraminoJ, tetraminoL, tetraminoU, tetraminoE
    ];
    /* Cor de cada peca do nosso jogo */
    const cores = ['Aqua','Gold','Deeppink','Red','DarkOrange','LimeGreen',cor_especial];

    /* ----- Variáveis Globais ----- */
    var pecaAtual;
    var tabuleiro = [];
    var qtde_linhas = 20;
    var qtde_colunas = 10;
    var chave = 1;/* Indica a direção dos movimentos das peças */
    var tabuleiroRotacionado = false;
    var yi = -2; /* Posicão y inicial de cada peça do jogo */

    /* Variáveis sobre os dados da jogada */
    var segundos = 0;
    var velId;  /* id da velocidade */
    var cronId; /* id do cronômetro */
    var velocidade = 1000; /* Define a velocidade do jogo */
    var qtde_linhas_apagadas=0;
    var pontuacao = 0;
    var ultimaPontuacao = 0;
    var nivel=1;
    var pause = false; /* Indica se a peça seguinte pode se mover para baixo */
    var jogando = true;

    window.inicializarTabuleiro = function (){
        /* Obtém o tamanho do tabuleiro escolhido pelo usuário */
        var tam = document.getElementsByName("tamanho");
        for(i = 0; i < tam.length; i++) {
            if(tam[i].checked){
                if(tam[i].value == "pequeno"){
                    qtde_linhas = 20;
                    qtde_colunas = 10;
                    break;
                }
                else if (tam[i].value == "grande"){
                    qtde_linhas = 22;
                    qtde_colunas = 44;
                    break;
                }
            }
        }

        /* Remove o formulário de escolha de tamanho do tabuleiro e altera a altura do canvas de 0px para auto  */
        document.getElementById("form_content").remove();

        /* Exibe o label de pontuação e velocidade do jogo */
        document.getElementById("dados_partida").style.visibility = "visible";
        document.getElementById("dados_partida").style.height = "auto";
        document.getElementById("dados_partida").style.width = "auto";
        document.getElementById("dados_partida").style.margin = "20px";

        document.getElementById("canvas_jogo").style.visibility = "visible";
        document.getElementById("canvas_jogo").style.height = "auto";
        document.getElementById("canvas_jogo").style.width = "auto";
        document.getElementById("canvas_jogo").style.margin = "20px";


        /* Preenche o array Tabuleiro com a cor do fundo padrão */
        for(var i=0;i<qtde_linhas;i++){
                tabuleiro[i] = [];
                for(var j=0;j<qtde_colunas;j++){
                    tabuleiro[i][j] = cor_fundo;
                }
        }

        iniciarJogo();
    };

    function iniciarJogo(){
        desenharTabuleiro();
        velId = setInterval(moverNaVertical, velocidade);
        cronId = setInterval(cronometro, 1000);
    }

	function finalizarJogo(pontuacao,nivel,segundos,qtde_linhas_apagadas){
		var http = new XMLHttpRequest();
		var url = "gameover.php";
		var params = "pontuacao="+pontuacao+"&nivel="+nivel+"&segundos="+segundos+"&linhas="+qtde_linhas_apagadas;
		http.open("POST", url, true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200) {
				document.getElementById("canvas_jogo").remove();
        	    var tagh1 = document.createElement("h1");
				var tagp = document.createElement("p");
				var textoh1 = document.createTextNode("Game Over!");
				var textop = document.createTextNode("Deseja jogar novamente? Clique na aba 'Tetris' do menu ou recarregue a página.");
				tagh1.appendChild(textoh1);
				tagp.appendChild(textop);

				var lista = document.getElementById("dados_partida");
				lista.insertBefore(tagh1, lista.childNodes[0]);
				lista.insertBefore(tagp, lista.childNodes[1]);
			}
		}
		http.send(params);
	}

    function desenharTabuleiro(){
        contexto.canvas.height = qtde_linhas*tam_quadrado;
        contexto.canvas.width = qtde_colunas*tam_quadrado;

        for(var i=0;i<qtde_linhas;i++){
            for(var j=0;j<qtde_colunas;j++){
                desenharQuadrado(j,i,tabuleiro[i][j]);
            }
        }

        pecaAtual = gerarPecaAleatoria();
    }

    function desenharQuadrado(x, y, cor){
        contexto.fillStyle = cor;
        contexto.strokeStyle ="white";
        contexto.fillRect(x * tam_quadrado, y * tam_quadrado, tam_quadrado, tam_quadrado);
        contexto.strokeRect(x * tam_quadrado, y * tam_quadrado, tam_quadrado, tam_quadrado);
    }

    function gerarPecaAleatoria(){
    	if(!pause){
	        var numRandom = Math.floor(Math.random()*tetraminos.length);
	        yi = tabuleiroRotacionado == true ? 21 : -2;
	        return new Peca(xi, yi, tetraminos[numRandom], cores[numRandom], 0);
    	}
    }

    function desenharPeca(peca){
        var p = peca.tipo[peca.rotacao];
        for(var l = 0; l < p.length; l++){
            for(var c = 0; c < p.length; c++){
                if(p[l][c] == 1){
                    desenharQuadrado(peca.x + c, peca.y + l, peca.cor);
                }
            }
        }
    }

    function apagarPeca(peca){
        var p = peca.tipo[peca.rotacao];
        for(var l = 0; l < p.length; l++){
            for(var c = 0; c < p.length; c++){
                if(p[l][c] == 1){
                    desenharQuadrado(peca.x + c, peca.y + l, cor_fundo);
                }
            }
        }
    }

    function gravarPecaNoTabuleiro (peca){
        var p= peca.tipo[peca.rotacao];

        for (var l=0;l<p.length;l++){
            for (var c=0; c<p.length; c++){
                if (p[l][c]==1){
                    tabuleiro[peca.y+l][peca.x+c]=peca.cor;
                }
            }
        }
    }

    /* Obtém as teclas clicadas no teclado e chama a função correspondente a cada tecla */
    document.addEventListener('keydown', (event) => {
        var tecla = event.keyCode;
        switch(tecla) {
            case 37:
                moverParaEsquerda(pecaAtual);
                break;
            case 38:
                rotacionarPeca(pecaAtual);
                break;
            case 39:
                moverParaDireita(pecaAtual);
                break;
            case 40:
                moverNaVertical();
                break;
            default:
        }
    });

    function moverNaVertical(){
        if(jogando){
            chave = tabuleiroRotacionado == true ? -1 : 1;
            if(!verificarColisao(0, chave, pecaAtual)){
                pause = true;
                apagarPeca(pecaAtual);
                pecaAtual.y+=chave;
                desenharPeca(pecaAtual);
            }
            else {
                   pause = true;
                if (!gameOver(pecaAtual)){
                    gravarPecaNoTabuleiro(pecaAtual);
                    verificarJogada();
                    pause = false;
                    pecaAtual = gerarPecaAleatoria();
                } else {
                    clearInterval(velId);
                    clearInterval(cronId);
                    jogando = false;
                    finalizarJogo(pontuacao,nivel,segundos,qtde_linhas_apagadas);
                }
            }
            pause = false;
        }
    }

   function moverParaEsquerda(peca){
	   if(!verificarColisao(-1,0, pecaAtual)){
	       apagarPeca(peca);
	       peca.x--;
	       desenharPeca(peca);
	   }
	}

    function moverParaDireita(peca){
	    if(!verificarColisao(1,0, pecaAtual)){
	       apagarPeca(peca);
	       peca.x++;
	       desenharPeca(peca);
	    }
	}

    function rotacionarPeca(peca){
        var novaRotacao = 0;

        if(peca.rotacao < 3){
            novaRotacao++;
        }
        else {
            novaRotacao = 0;
        }

        var pecaRotacionada = new Peca(peca.x, peca.y, peca.tipo, peca.cor, (peca.rotacao+1)%peca.tipo.length);
        var direcao = 0; // verifica se a colisão aconteceu no lado esquerdo ou direito do tabuleiro

        if(verificarColisao(direcao, 0, pecaRotacionada)){
            if(pecaRotacionada.x > qtde_colunas/2){ // verifica se a peça colidiu com o lado esquedo
                direcao = -1;
       		} else {
        		direcao = 1;
       		}
    	}

	    if(!verificarColisao(direcao, 0, pecaRotacionada)){
	        apagarPeca(peca);
	        peca.x += direcao;
	        peca.rotacao = (peca.rotacao+1)%peca.tipo.length;
	        desenharPeca(peca);
	    }
	}

	function verificarColisao(x, y, peca){
	    var p = peca.tipo[peca.rotacao];

	    for (var l = 0; l < p.length; l++) {
	        for (var c = 0; c < p.length; c++) {
	            if(p[l][c]){
	                var proximoX = peca.x + c + x;
	                var proximoY = peca.y + l + y;

	                if (proximoX < 0 || proximoX >= qtde_colunas || (proximoY >= qtde_linhas && chave > 0) || (proximoY < 0 && chave < 0)) {
	                    return true;
	                }

	                if ((proximoY > 0 && chave > 0) || (proximoY < qtde_linhas && chave <0)) {
	                    if (tabuleiro[proximoY][proximoX] != cor_fundo) {
	                        return true;
	                    }
	                }

	            }
	        }
	    }
	    return false;
	}

	function verificarJogada(){
	   var linha_completa = true;
	   var qtde_linhas_completas=0;
	   var acheiPecaEspecial = false;
	   var rotacionar_tabuleiro=false;

     if(chave > 0){
       for (var i=0;i<qtde_linhas;i++){
  	       linha_completa = true;
  	       acheiPecaEspecial=false;
  	       for (var j=0; j<qtde_colunas;j++){
  	           if (tabuleiro[i][j]==cor_fundo){
  	               linha_completa = false;
  	               break;
  	           }
  	           else if(tabuleiro[i][j] == cor_especial){
  	               acheiPecaEspecial = true;
  	           }
  	       }

  	       if (linha_completa == true){
  	           if(acheiPecaEspecial == true){
  	               rotacionar_tabuleiro = true;
  	           }
  	           qtde_linhas_completas++;
  	           apagarLinha (i);
  	           atualizarLinhasApagadas();
  	       }
  	   }
     }
     else if (chave < 0){
         for (var i=qtde_linhas-1;i>=0;i--){
    	       linha_completa = true;
    	       acheiPecaEspecial=false;
    	       for (var j=0; j<qtde_colunas;j++){
    	           if (tabuleiro[i][j]==cor_fundo){
    	               linha_completa = false;
    	               break;
    	           }
    	           else if(tabuleiro[i][j] == cor_especial){
    	               acheiPecaEspecial = true;
    	           }
    	       }

    	       if (linha_completa == true){
    	           if(acheiPecaEspecial == true){
    	               rotacionar_tabuleiro = true;
    	           }
    	           qtde_linhas_completas++;
    	           apagarLinha (i);
    	           atualizarLinhasApagadas();
    	       }
    	   }
     }


	   if(qtde_linhas_completas>0){
	       atualizarPontuacao(qtde_linhas_completas);
	       validarNivel();

	       if(rotacionar_tabuleiro == true){
	           rotacionarTabuleiro();
	       }
	   }
	}

	function apagarLinha (nlinha){
	   if(chave > 0){
	       for (var i=nlinha; i>0; i--){
	           for (var j=0; j<qtde_colunas; j++){
	               tabuleiro[i][j]= tabuleiro[i-1][j];
	           }
	       }

	       for (var j=0;j<qtde_colunas;j++){
	           tabuleiro[0][j]=cor_fundo;
	       }
	   }
	   else if(chave < 0){
	       for (var i=nlinha; i<qtde_linhas-1; i++){
	           for (var j=0; j<qtde_colunas; j++){
	               tabuleiro[i][j]= tabuleiro[i+1][j];
	           }
	       }

	      for (var j=0;j<qtde_colunas;j++){
	           tabuleiro[qtde_linhas-1][j]=cor_fundo;
	       }
	   }

	    desenharTabuleiro(qtde_linhas,qtde_colunas);
	}

	function rotacionarTabuleiro(){
    tabuleiroRotacionado = tabuleiroRotacionado == false ? true : false;
	    var tabuleiro2=[];
	    var auxLinhas=qtde_linhas-1;
	    var auxColunas=qtde_colunas-1;

	    for(var i=0;i<qtde_linhas;i++){
	        tabuleiro2[i] =[];
	        auxColunas=qtde_colunas-1;
	        for(var j=0;j<qtde_colunas;j++){
	            tabuleiro2[i][j]=tabuleiro[auxLinhas][auxColunas];

	            auxColunas--;
	        }
	        auxLinhas--;
	    }

	    tabuleiro = tabuleiro2;
	    desenharTabuleiro();
	}

    /* Funções para validar e alterar todos os dados da jogada */
    function atualizarLinhasApagadas(){
        qtde_linhas_apagadas++;
        document.getElementById("linhase").innerHTML= qtde_linhas_apagadas;
    }

    function atualizarPontuacao(nlinhasapagadas){
        var bonus=nlinhasapagadas;
        pontuacao+= (nlinhasapagadas*10)*bonus;
        document.getElementById("pontuacao").innerHTML= pontuacao;
    }

    function validarNivel(){
        var diferenca = pontuacao - ultimaPontuacao;
        if ((diferenca%300==0)){
            nivel++;
            velocidade-=100;
            setInterval(moverNaVertical, velocidade);
            document.getElementById("nivel").innerHTML=nivel;
            ultimaPontuacao = pontuacao;
        }
    }

    function cronometro(){
        segundos= segundos + 1;
        document.getElementById("tempo").innerHTML= segundos + " s";
    }

    function gameOver(peca){
	   var p= peca.tipo[peca.rotacao];

	   for (var l=0;l<p.length;l++){
	       for (var c=0; c<p.length; c++){
	           if (p[l][c]==1){
	               if ((peca.y+l<0 && chave > 0) || (peca.y+l>qtde_linhas-1 && chave < 0)){
	                  return true;
	               }
	           }
	       }
	   }

	   return false;
    }
});
