<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Jogador{
    private $nome;
    private $vidaTotal;
    private $vidaAtual;
    private $posicaoAtual = array();
    private $inventario = array();
    
       /*
    * DESCR: O método Combater() é um método abstrato da classe Jogador 
    * que está somente assinado e será sobrescrito nas classes filhas,
    * tem a funçao de combater o outro jogador
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: S/ENTRADA
    * SAÍDA: S/SAÍDA
    */
    public abstract function combater();
    
    /*
    * DESCR: O método Defender() é um método abstrato da classe Jogador 
    * que está somente assinado e será sobrescrito pelas classes filhas,
    * tem a função de defender-se do ataque do outro jogador
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: Ataque do item, jogador de Defesa
    * SAÍDA: S/SAÍDA
    */
    public abstract function defender($ataque, $jogadorDefesa);
    
    /*
    * DESCR: O método RegistraDano() é um método da classe Jogador 
    * que registra o dano causado pela ataque da arma do outro jogador,
    * antes verificando se a vida é menor que o dano, se sim ele chama o método morrer(),
    * se não, irá perder pontos da vida.
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 2
    * ENTRADA: Dano(ataque da arma), jogador de Defesa, vida do Jogador
    * SAÍDA: Vida
    */
    
    public function registrarDano($dano, $jogadorDefesa, $vida){
        if($vida <= $dano){
            $this->morrer($jogadorDefesa);
        }else{
            $vida -= $dano;
            return $vida;
        }
    }
    
    /*
    * DESCR: O método Morrer() é chamado após um 
    * ataque bem-sucedido do jogador contra o outro. 
    * Este método retornará uma mensagem a ser exibida na tela
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 2
    * ENTRADA: Jogador
    * SAÍDA: Mensagem de Game Over
    */
    public function morrer($jogadorDefesa){
        $msg = $jogadorDefesa ." MORREU!";
        return $msg;
    }
    
    /*
    * DESCR: O método movimentarDireita() tem a função de movimentar 
    * o objeto jogador para o lado direito da posição atual em que ele está,
    * essa função chama outra chamada movimentar()
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 3
    * ENTRADA: Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: S/SAÍDA
    */
    public function movimentarDireita($ObX, $ObY){
        $novaPosicao = array();
        $novaPosicao["x"] = $this->posicaoAtual["x"];
        $novaPosicao["y"] = $this->posicaoAtual["y"] + 1;
        $this->movimentar($novaPosicao, $ObX, $ObY);

    }
    
    /*
    * DESCR: O método movimentarEsquerda() tem a função de movimentar 
    * o objeto jogador para o lado esquerdo da posição atual em que ele está,
    * essa função chama outra chamada movimentar()
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 3
    * ENTRADA: Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: S/SAÍDA
    */
    public function movimentarEsquerda($ObX, $ObY){
        $novaPosicao = array();
        $novaPosicao["x"] = $this->posicaoAtual["x"];
        $novaPosicao["y"] = $this->posicaoAtual["y"] - 1;
        $this->movimentar($novaPosicao, $ObX, $ObY);
    }
    
    /*
    * DESCR: O método movimentarCima() tem a função de movimentar 
    * o objeto jogador para cima da posição atual em que ele está,
    * essa função chama outra chamada movimentar()
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 3
    * ENTRADA: Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: S/SAÍDA
    */
    public function movimentarCima($ObX, $ObY){
        $novaPosicao = array();
        $novaPosicao["x"] = $this->posicaoAtual["x"] - 1;
        $novaPosicao["y"] = $this->posicaoAtual["y"];
        $this->movimentar($novaPosicao, $ObX, $ObY);
    }
    
    /*
    * DESCR: O método movimentarBaixo() tem a função de movimentar 
    * o objeto jogador para baixo da posição atual em que ele está,
    * essa função chama outra chamada movimentar()
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 3
    * ENTRADA: Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: S/SAÍDA
    */
    public function movimentarBaixo($ObX, $ObY){
        $novaPosicao = array();
        $novaPosicao["x"] = $this->posicaoAtual["x"] + 1;
        $novaPosicao["y"] = $this->posicaoAtual["y"];
        $this->movimentar($novaPosicao, $ObX, $ObY);
    }
    
    /*
    * DESCR: O método movimentar tem a função de movimentar 
    * o objeto jogador para o lado em que foi solicitado anteriormente.
    * Antes do movimento é chamado o método validarMovimento()
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 3
    * ENTRADA: Posicao solicitada, Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: S/SAÍDA
    */
    public function movimentar($novaPosicao, $ObX, $ObY){
        //var_dump($ObX);
        if($this->validarMovimento($novaPosicao, $ObX, $ObY)){
            $this->posicaoAtual["x"] = $novaPosicao["x"];
            $this->posicaoAtual["y"] = $novaPosicao["y"];
        }
    }
    
    /*
    * DESCR: O método validarMovimento() tem a função de verificar         
    * se há obstáculo ou se não existe célula. Caso um dos dois seja verdadeiro, 
    * o jogador não se movimenta, se ambos forem falso
    * o jogador está livre para movimentar-se para a direção solicitada
    * AUTOR: Daniel Pereira Zitei
    * HORAS: 2
    
    * ENTRADA: Posição solicitada, Array de obstáculos na posição X, Array de obstáculos na posição Y
    * SAÍDA: Booleano
    */
    public function validarMovimento($novaPosicao, $ObX, $ObY){

        if(($novaPosicao["x"] >= 0 && $novaPosicao["x"] < 5)&&
           ($novaPosicao["y"] >= 0 && $novaPosicao["y"] < 6)){
               
               for($i = 0; $i < count($ObX); $i++){
                   if($ObX[$i] == $novaPosicao['x'] && 
                        $ObY[$i] == $novaPosicao['y']){
                            return false;
                    }
               }
            return true;
        }else{
            return false;
        }
    }
    
        /*
    * DESCR: O método getVida() retorna a vida total(original) do jogador
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: S/ENTRADA
    * SAÍDA: Vida
    */
    public function getVida(){
        return $this->vidaTotal;
    }
    
    /*
    * DESCR: O método geNome() retorna o nome do jogador
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: S/ENTRADA
    * SAÍDA: Nome
    */
    public function getNome(){
        return $this->nome;
    }
    
    /*
    * DESCR: O método getVida() retorna a posição atual do jogador no tabuleiro
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: S/ENTRADA
    * SAÍDA: Posição atual
    */
    public function getPosicaoAtual(){
        return $this->posicaoAtual;
    }
    
        /*
    * DESCR: O método abstrato getJogador() está somente assinado nessa classe
    *  e será sobrescrito nas classes filhas retornando os detalhes do jogador
    * AUTOR: Nathan Caraviello Couto
    * HORAS: 1
    * ENTRADA: S/ENTRADA
    * SAÍDA: S/SAÍDA
    */
    public abstract function getJogador();
    
}
?>