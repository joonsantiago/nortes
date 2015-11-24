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
    
    public function printFormulario($foto, $titulo, $pasta) {
    
    	$qtd = sizeof($foto);
    
    	$saida = '<section id=""> 
    			<form action="/nortes/public/portfolio/dashboard" method="post">
    			<input type="hidden" name="titulo" value="' . $titulo . '">
    			<input type="hidden" name="pasta" value="' . $pasta . '">
    			<div class="container">
                    <div class="row">';
    	for ($i = 0; $i < $qtd; $i++) {
    		if (($i % 2) == 0) {
    			$saida .= '<div class="col-md-12 col-lg-12">
                <div class="col-sm-5">
            <img class="img-responsive img-centered" src="' . $foto[$i] . '" alt="">
                </div>
    
                <div class="col-md-7">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
            </div>';
    		} else {
    			$saida .= '<div class="col-md-12 col-lg-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <img class="img-responsive img-centered" src="' . $foto[$i] . '" alt="">
                </div>
            </div>';
    		}
    	}
    
    	$saida .= '<p>
                <center>
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Salvar postagem">
    				<a href="#" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-clear"></i> <b>CANCELAR</b></a>
    			</center>
                </p>
            </div>
          </div>
    	 </form>
        </section>
        ';
    	
    	return $saida;
    }
    
}