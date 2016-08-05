<?php

namespace Application\Model;

class Servicos {
    
    public $id;
    public $titulo;
    public $descricao;
    public $faicon;
    
    function exchangeArray($dados){
        $this->id = (isset($dados['id'])) ? $dados['id']:null;
        $this->titulo = (isset($dados['titulo'])) ?$dados['titulo']:null;
        $this->descricao = (isset($dados['descricao'])) ?$dados['descricao']:null;
        $this->faicon = (isset($dados['faicon'])) ?$dados['faicon']:null;
    }
    
    function getArrayCopy(){
        return array(
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'faicon' => $this->faicon,
        );
    }
    
}