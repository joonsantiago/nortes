<?php

namespace Application\Model;

class Portfolio {
    
    public $id;
    public $nome;
    
    function exchangeArray($dados){
        $this->id = (isset($dados['id'])) ? $dados['id']:null;
        $this->nome = (isset($dados['nome'])) ?$dados['nome']:null;
    }
    
    function getArrayCopy(){
        return array(
            'id' => $this->id,
            'nome' => $this->nome
        );
    }
    
}