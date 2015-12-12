<?php


namespace Application\Model;

class Fotos {
	
	public $id;
	public $descricao;
	public $nome;
	public $portfolio_id;
	
	function exchangeArray($dados){
		$this->id = (isset($dados['id'])) ? $dados['id']:null;
		$this->descricao = (isset($dados['descricao'])) ? $dados['descricao']:null;
		$this->nome = (isset($dados['nome'])) ? $dados['nome']:null;
		$this->portfolio_id = (isset($dados['portfolio_id'])) ? $dados['portfolio_id']:null;
	}
	
	function getArrayCopy(){
		return array(
			'id' => $this->id,
			'descricao' => $this->descricao,
			'nome' => $this->nome,
			'portfolio_id' => $this->portfolio_id,
			
		);
	}
	
}