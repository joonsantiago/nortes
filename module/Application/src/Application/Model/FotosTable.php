<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
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
		$result = $this->fotosGateway->select();
		return $result;
	}
	
}