<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Application\Model\Fotos;
use Application\Model\ArquivoConfiguracao;

class FotosTable extends ArquivoConfiguracao {
	
	protected $fotosGateway;
	protected $id;
	
	function __construct(TableGateway $fotosGateway){
		$this->fotosGateway = $fotosGateway;
	}
	
	function salvar(Fotos $fotos){
            $id_foto = (int) $fotos->id;
            $fotos = (array) $fotos;
            
            if($id_foto == 0){
		$this->fotosGateway->insert($fotos);
                $this->id = (int) $this->fotosGateway->lastInsertValue;
            }else{
                $this->fotosGateway->update($fotos , array(
                    'id' => $id_foto,
                ));
                $this->id = $id_foto;
            }
            return $this->id;
	}
        
        public function changeFotos($id){
            $adapter = ArquivoConfiguracao::ConfAdapter();
            //$adapter = $adapter->ConfAdapter();
            $statement = $adapter->query('SELECT fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, fotos.capa, portfolio.nome as nome_port from fotos 
                                        inner join portfolio on portfolio.id = fotos.portfolio_id and fotos.portfolio_id ='. $id);

            $result = $statement->execute();
            return $result;
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
                $adapter = ArquivoConfiguracao::ConfAdapter();
                //$adapter = $adapter->ConfAdapter();
                $statement = $adapter->query('SELECT fotos.id, fotos.portfolio_id, fotos.nome, fotos.descricao, fotos.capa, portfolio.nome as nome_port from fotos
                                            inner join portfolio on portfolio.id = fotos.portfolio_id
                                            inner join (select portfolio.id from portfolio order by portfolio.id desc limit 12 offset '.$page.') a on portfolio.id = a.id;');

            $result = $statement->execute();
            return $result;
        }

	
}