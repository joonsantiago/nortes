<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Application\Model\Fotos;


class FotosTable {
	
	protected $fotosGateway;
	protected $id;
	
	function __construct(TableGateway $fotosGateway){
		$this->fotosGateway = $fotosGateway;
	}
	
	function salvar(Fotos $fotos){
		$fotos = (array) $fotos;
		$this->fotosGateway->insert($fotos);
	}
	
	public function fetchAll(){
		//select fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, portfolio.nome 
                //from fotos inner join portfolio on fotos.portfolio_id = portfolio.id;
            $sqlSelect = $this->fotosGateway->getSql()->select();
            
            $sqlSelect->columns(array('id','portfolio_id','nome', 'descricao'));
            $sqlSelect->join('portfolio', 'fotos.portfolio_id = portfolio.id', array('nome_portfolio' => 'nome'), 'inner');
            
            $statement = $this->fotosGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
            $result = $statement->execute();
            
            return $result;
	}
	
}