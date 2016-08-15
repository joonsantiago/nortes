<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Application\Model\Servicos;
use Zend\Db\Sql\Sql;

class ServicosTable extends ArquivoConfiguracao {
    
    protected $servicosGateway;
    protected $id;
    
    /*function __construct(TableGateway $servicosGateway){
            $this->servicosGateway = $servicosGateway;
    }*/    
    public function _selectAll(){
        $adapter = $this->ConfAdapter();
        $sql = new Sql($adapter);
        
        $select = $sql->select('servicos')->columns(array('*'));
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $stm = $adapter->query($sqlString);
        $result = $stm->execute();
        return $result;
    }
    
    public function _select($id){
        $adapter = $this->ConfAdapter();
        $sql = new Sql($adapter);
        
        $select = $sql->select('servicos')->columns(array('*'))->where(array('id' => $id));
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $stm = $adapter->query($sqlString);
        $result = $stm->execute();
        return $result;
    }
    
    public function salvar(Servicos $servicos){
        #$data = array(
        #    'nome' => $portfolio->nome
        #);
        $id_update = (int) $servicos->id;
        $servicos = (array) $servicos;
        if($id_update == 0){
            $this->id = $this->_insert($servicos);
            //$this->id = (int) $this->servicosGateway->lastInsertValue;
        }else{
            /*$this->servicosGateway->update($servicos, array(
                'id' => $id_update,
            ));*/
            $this->id = $id_update;
        }
        return $this->id;
    }
     
    public function finalizarAcao($palavra){
    	$saida = '
				     <div class="container">
				        <div class="row">
				            <div class="col-md-4 text-center"></div>
				            <div class="col-md-4 text-center">
				                <div class="alert alert-success fade in">
				                    <a href="#" class="close" data-dismiss="alert">&times;</a>
				                    <strong>Concluído:</strong> Serviço '.$palavra.' com sucesso.
				                </div>
    	
				            </div>
				        </div>
				    </div>';
    	
    	return $saida;
    }
    
    public function _insert(Servicos $servicos){
        $adapter = $this->ConfAdapter();
        
        $servicos = (array) $servicos;
        $sql = new Sql($adapter);
        if($servicos['id'] == 0){
            $insert = $sql->insert('servicos')->values($servicos);
        }else{
            $insert = $sql->update('servicos')->set($servicos)->where(array('id' => $servicos['id']));
        }
        
        $sqlString = $sql->getSqlStringForSqlObject($insert);
        $adapter->query($sqlString, Adapter::QUERY_MODE_EXECUTE);
        
        $statement = $adapter->query('select id from servicos order by id desc limit 1');
        $stm = $statement->execute();
        foreach ($stm as $dados):{
            $result= $dados['id'];
        }endforeach;
        
        return $result;
    }
    
    public function _delete($id){
        $adapter = $this->ConfAdapter();
        $sql = new Sql($adapter);
        
        $delete = $sql->delete('servicos')->where(array('id' => $id));
        $sqlString = $sql->getSqlStringForSqlObject($delete);
        $stm = $adapter->query($sqlString);
        $stm->execute();
        return $this->finalizarAcao("excluído");
    }
}