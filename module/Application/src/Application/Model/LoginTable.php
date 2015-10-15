<?php

namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

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
    
}