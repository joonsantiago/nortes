<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\Portfolio;

class PortfolioTable{
    
    protected $tableGateway;
    protected $id; 
            
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function salvar(Portfolio $portfolio){
        $data = array(
            'nome' => $portfolio->nome
        );
        $this->tableGateway->insert($data);
        $this->id = (int) $this->tableGateway->lastInsertValue;
        return $this->id;
    }
    
}