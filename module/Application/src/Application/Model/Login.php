<?php

namespace Application\Model;

class Login{
    
    public $idlogin;
    public $usuario;
    public $senha;
    
    //O METODO TEM QUE SE CHAMAR EXCHANGE ARRAY
    function exchangeArray($data){
        $this->idlogin = (isset($data['idlogin'])) ? $data['idlogin']:null;
        $this->usuario= (isset($data['usuario'])) ? $data['usuario']:null;
        $this->senha = (isset($data['senha'])) ? $data['senha']:null;        
    }
    
    function getArrayCopy(){
        return array(
            'idlogin' => $this->idlogin,
            'usuario' => $this->usuario,
            'senha' => $this->senha,
        );
    }    
}