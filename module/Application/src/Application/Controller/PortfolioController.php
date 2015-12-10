<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Portfolio;
use Zend\File\Transfer\Adapter\Http;
use Application\Model\PortfolioTable;
use Application\Model\Fotos;

class PortfolioController extends AbstractActionController {

    public $lista = array();
    protected $portfolioTable;
    protected $fotosTable;

    public function indexAction() {
        return new ViewModel();
    }

    public function dashboardAction() {
        $request = $this->getRequest();
        $saida = "";
        if ($request->isPost()){
        	$variaveis = $request->getPost();
        	$portfolioObj = new Portfolio();
        	$fotos = new Fotos();
        	
        	$portfolio = array (
        		'nome'=> $variaveis['titulo']
        	);
        	$portfolioObj->exchangeArray($portfolio);
        	$id_portfolio = $this->getPortfolioTable()->salvar($portfolioObj);
        	
        	$descricao = array();
        	$tam = ((sizeof($variaveis) - 2) / 2);
        	for($i=0; $i < $tam ;$i++){
        		$descricao["portfolio_id"] = $id_portfolio;
        		$descricao["nome"] = $variaveis['nome_'.$i];
        		$descricao["descricao"] = $variaveis['descricao_'.$i];
        		
        		$fotos->exchangeArray($descricao);
        		$this->getFotosTable()->salvar($fotos);
        	}
        	$saida = PortfolioTable::finalizarPort($variaveis['pasta'], $id_portfolio);
        }
        	return array(
        		'saida' => $saida,
        	);
    }

    public function tituloAction() {

    	
    }

    public function addAction() {
        $adapter = new Http();
        $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/';
        $adapter->setDestination($destino);
        $request = $this->getRequest();
        $titulo = $pasta = $hidden = $saida = null;
        if ($request->isPost()) {
			$titulo = $request->getPost('titulo');
            date_default_timezone_set('America/Sao_Paulo');
            $pasta = date("dmYHis");
            $files = $adapter->getFileInfo();

            if (!empty($files)) {
                mkdir($destino . $pasta . '/', 0777);
                $qtd = 0;
                foreach ($files as $file => $info) {
                    //$adapter->addFilter('Rename', $destino . $pasta . '/' . $info['name']);
                    $adapter->addFilter('Rename', $destino . $pasta . '/' . $qtd . '.jpg');
                    $adapter->receive($file);
                    $this->lista[$qtd] = '/nortes/public/img/fotos/'
                            . $pasta . '/' . $qtd . '.jpg';
                    $qtd++;
                }
                $saida = PortfolioTable::printFormulario($this->lista, $titulo, $pasta);
                $hidden = 'hidden = "true" ';
            }
            
            return array(
            	'titulo' => $titulo,
            	'saida' => $saida,
            	'hidden' => $hidden,
            );
        }
    }

    public function getPortfolioTable() {
        if (!$this->portfolioTable) {
            $sm = $this->getServiceLocator();
            $this->portfolioTable = $sm->get('Application\Model\PortfolioTable');
        }
        return $this->portfolioTable;
    }
    
    public function getFotosTable(){
    	if(!$this->fotosTable){
    		$sm = $this->getServiceLocator();
    		$this->fotosTable = $sm->get('Application\Model\FotosTable');
    	}
    	return $this->fotosTable;
    }

}
