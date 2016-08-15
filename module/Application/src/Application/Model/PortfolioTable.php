<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\Portfolio;
use Zend\Db\Adapter\Adapter;

class PortfolioTable extends ArquivoConfiguracao{
    
    protected $tableGateway;
    protected $id; 
            
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function editarPortfolio(){
        
    }
    
    public function fetchAll($offset){
    	$sqlSelect = $this->tableGateway->getSql()->select();
        
        //$sqlSelect->columns(array(' * '));
        $sqlSelect->limit(12);
        $sqlSelect->offset($offset);
        $sqlSelect->order('id DESC');
        
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $result = $statement->execute();
        //Converter objeto em array
        //$r = $result->toArray();
    	return $result;
    }
    
    public function salvar(Portfolio $portfolio){
        #$data = array(
        #    'nome' => $portfolio->nome
        #);
        $id_update = (int) $portfolio->id;
        $portfolio = (array) $portfolio;
        if($id_update == 0){
            $this->tableGateway->insert($portfolio);
            $this->id = (int) $this->tableGateway->lastInsertValue;
        }else{
            $this->tableGateway->update($portfolio, array(
                'id' => $id_update,
            ));
            $this->id = $id_update;
        }
        return $this->id;
    }
    
    public function printFormulario($foto, $titulo, $pasta, $id_port, $id_foto) {
    
    	$qtd = sizeof($foto);
    
    	$saida = '<section id="">
    			<h2> '.$titulo.' </h2> 
    			<form action="/nortes/public/dashboard" method="post">
    			<input type="hidden" name="titulo" value="' . $titulo . '">
    			<input type="hidden" name="pasta" value="' . $pasta . '">
    			<input type="hidden" name="id_port" value="' . $id_port . '">
    			<div class="container">
                    <div class="row">';
    	for ($i = 0; $i < $qtd; $i++) {
    			$saida .= '<div class="col-md-12 col-lg-12">
                <div class="col-sm-5">
            <img class="img-responsive img-centered" src="' . $foto[$i] . '" alt="">
            <input type="hidden" name="id_foto_'.$i.'" value="'.$id_foto[$i]['id'].'">
            <input type="radio" name="capa" value="'.$i.'" required="true" class="form-control">Esta será a foto da capa
                </div>
    
                <div class="col-md-7">
                    <div class="form-group">';
                        if(isset($id_foto[$i]['nome'])){
                            $saida.= '<input type="text" class="titulo-text-fotos" value="'.$id_foto[$i]['nome'].'" name ="nome_'.$i.'" id="name'.$i.'" required data-validation-required-message="Please enter your name.">';
                        }else{
                            $saida.= '<input type="text" class="titulo-text-fotos" placeholder="Your Name *" name ="nome_'.$i.'" id="name'.$i.'" required data-validation-required-message="Please enter your name.">';
                        }
                        $saida .='<p class="help-block text-danger"></p>
                    </div>
                    <div class="form-group">';
                        if(isset($id_foto[$i]['descricao'])){
                            $saida .= '<textarea class="area-text-fotos" rows="10" name="descricao_'.$i.'" id="message" required data-validation-required-message="Please enter a message.">'.str_replace( "<br />", '', $id_foto[$i]['descricao']).'</textarea>';
                        }else{
                            $saida .= '<textarea class="area-text-fotos" rows="10" placeholder="Your Message *" name="descricao_'.$i.'" id="message" required data-validation-required-message="Please enter a message."></textarea>';
                        }
                        $saida.='<p class="help-block text-danger"></p>
                    </div>
                </div>
            </div>';
    	}
    
    	$saida .= '<p>
                <center>
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Salvar postagem">
    				<a href="/nortes/public/dashboard/'.$pasta.'" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-clear"></i> <b>CANCELAR</b></a>
    			</center>
                </p>
            </div>
          </div>
    	 </form>
        </section>
        ';
    	
    	return $saida;
    }
    
    public function finalizarPort($pasta, $id, $status = NULL){
    	
    	if(!is_null($pasta) && $status == NULL){
            $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/';
            $dest = $destino.$pasta;
            rename($dest , $destino.'/'.$id);
            $palavra = "cadastrado";
        }else{
            $palavra = is_null($status) ? "atualizado" : $status;
        }

    	$saida = '
				     <div class="container">
				        <div class="row">
				            <div class="col-md-4 text-center"></div>
				            <div class="col-md-4 text-center">
				                <div class="alert alert-success fade in">
				                    <a href="#" class="close" data-dismiss="alert">&times;</a>
				                    <strong>Concluído:</strong> Portfólio '.$palavra.' com sucesso.
				                </div>
    	
				            </div>
				        </div>
				    </div>';
    	
    	return $saida;
    }
    
    public function deletarPort($id){
        $this->tableGateway->delete(array(
            'id' => $id,
        ));
        return $this->finalizarPort(null, null, 'excluído');
    }
    
    public function qtd_Portfolio (){
        $adapter = $this->ConfAdapter();
        $statement = $adapter->query('select COUNT(*) as qtd_port from portfolio');

        $stm = $statement->execute();
        foreach ($stm as $dados):{
            $result= $dados['qtd_port'];
        }endforeach;
        return $result;
    }
}