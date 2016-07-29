<?php

namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

class LoginTable{
    
    protected $loginGateway;
    
    public function __construct(TableGateway $loginGateway) {
        $this->loginGateway = $loginGateway;        
    }
    
    public function getLogin($usuario, $senha){
        
        $rowset = $this->loginGateway->select(array(
            'usuario' => $usuario,
            'senha' => md5($senha),
        ));
        
        $row = $rowset->current();
        return $row;        
    }
    
    public function validarSessao(){
        $sessao = new Container();
        $seg = 1;
        if($sessao->registro){
            $seg = time() - $sessao->registro;
        }
        if(!empty($sessao->registro) && $seg < 300){
            $sessao->registro = time();
            return false;
        }else{
            $sessao->getManager()->getStorage()->clear();
            return true;
        }
    }
    
}