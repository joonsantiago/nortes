<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
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
	
	public function fetchAll($page){
            //select fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, portfolio.nome 
            //from fotos inner join portfolio on fotos.portfolio_id = portfolio.id;
            
            //Select que traz a quantidade de fotos dentro de cada portfolio
            //select COUNT(*) as qtd_fotos, fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, portfolio.nome
            //from fotos inner join portfolio on fotos.portfolio_id = portfolio.id  GROUP BY fotos.portfolio_id
            $sqlSelect = $this->fotosGateway->getSql()->select();
            
            $sqlSelect->columns(array('id','portfolio_id','nome', 'descricao'));
            $sqlSelect->join('portfolio', 'fotos.portfolio_id = portfolio.id', array('nome_portfolio' => 'nome'), 'inner');
            $sqlSelect->order(array('portfolio.id DESC'));
            //$sqlSelect->limit(12);
            
            $statement = $this->fotosGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
            $result = $statement->execute();
            
            return $result;
	}
        

        public function consultaSql($page){
                $adapter = new Adapter(array(
               'driver' => 'Mysqli',
               'database' => 'douglas',
               'username' => 'root',
               'password' => '',
               'charset' => 'utf8',
            ));
                $statement = $adapter->query('SELECT fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, portfolio.nome as nome_port from fotos
                                            inner join portfolio on portfolio.id = fotos.portfolio_id
                                            inner join (select portfolio.id from portfolio order by portfolio.id desc limit 12 offset '.$page.') a on portfolio.id = a.id;');

            $result = $statement->execute();
            return $result;
        }

	
}