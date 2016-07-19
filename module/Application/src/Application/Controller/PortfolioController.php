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
use Application\Model\FotosTable;
use Application\Model\Fotos;

class PortfolioController extends AbstractActionController {

    public $lista = array();
    protected $portfolioTable;
    protected $fotosTable;

    public function indexAction() {
        $page=$this->params()->fromRoute("id");
        $p = (int) (isset($page)) ? ($page) : 0;
        $page = $this->paginacao($page);
        $qtd_portfolios = PortfolioTable::qtd_Portfolio();
        $t = FotosTable::consultaSql($page);
        return new ViewModel(array(
        	'portfolios' => $this->getPortfolioTable()->fetchAll($page),
        	'fotos' => $t,
                'qtd_port' => $qtd_portfolios,
                'page' => $p,
        ));
    }

    public function dashboardAction() {
        $request = $this->getRequest();
        $pasta = $this->params()->fromRoute("id");
        $saida = "";
        if ($request->isPost()){
        	$variaveis = $request->getPost();
        	$portfolioObj = new Portfolio();
        	$fotos = new Fotos();
        	
        	$portfolio = array (
                    'id' => $variaveis['id_port'],
                    'nome'=> $variaveis['titulo'],
        	);
        	$portfolioObj->exchangeArray($portfolio);
        	$id_portfolio = $this->getPortfolioTable()->salvar($portfolioObj);
        	
        	$descricao = array();
        	$tam = sizeof($variaveis);
        	$tam = ((sizeof($variaveis) - 4) / 3);
        	for($i=0; $i < $tam ;$i++){
        		$descricao[$i]["portfolio_id"] = $id_portfolio;
        		$descricao[$i]["nome"] = $variaveis['nome_'.$i];
        		$descricao[$i]["descricao"] = $variaveis['descricao_'.$i];
        		$descricao[$i]["id"] = $variaveis['id_foto_'.$i];
                        if($variaveis['capa'] == $i){                        
                            $descricao[$i]["capa"] = true;
                        }else{
                            $descricao[$i]["capa"] = false;
                        }        		
        		//$fotos->exchangeArray($descricao);
        		//$this->getFotosTable()->salvar($fotos);
        	}
                if($portfolioObj->id == 0){
                    $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/'.$variaveis['pasta'].'/';
                    $j = 0;
                    foreach ($descricao as $d){
                        $fotos->exchangeArray($d);
                        $id_foto = $this->getFotosTable()->salvar($fotos);
                        rename ($destino.$j.'.jpg', $destino.$id_foto.'.jpg');
                        ++$j;
                    }

                    $saida = PortfolioTable::finalizarPort($variaveis['pasta'], $id_portfolio);
                }else{
                    foreach ($descricao as $d){
                        $fotos->exchangeArray($d);
                        $id_foto = $this->getFotosTable()->salvar($fotos);
                    }

                    $saida = PortfolioTable::finalizarPort(null, $id_portfolio);
                }
        }
        //caso seja selecionado cancelar
        if(!empty($pasta)){
           $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/'.$pasta;
           $conteudo = scandir($destino);
           foreach($conteudo as $arquivo){
               if(($arquivo != '.') && ($arquivo != '..')){
                   unlink($destino.'/'.$arquivo);
               }
           }
           rmdir($destino);            
        }
        return array(
                'saida' => $saida,
        );
    }

    public function tituloAction() {
        $id=$this->params()->fromRoute("id");
        $titulo=$this->params()->fromRoute("nome");
        
        if(isset($id) && isset($titulo)){
            return array(
                'id' => $id,
                'titulo' => $titulo,
            );
        }
    	
    }

    public function addAction() {
        $adapter = new Http();
        $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/';
        $adapter->setDestination($destino);
        $request = $this->getRequest();
        $titulo = $id_update = $pasta = $hidden = $saida = null;
        if ($request->isPost()) {
            $titulo = $request->getPost('titulo');
            $id_update = $request->getPost('id');
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
                $saida = PortfolioTable::printFormulario($this->lista, $titulo, $pasta, null, null);
                $hidden = 'hidden = "true" ';
            }else if(!is_null($id_update)){
                $fotos_update = FotosTable::changeFotos($id_update);
                $qtd = 0;
                $id_fotos = array();
                foreach ($fotos_update as $ft){
                    $this->lista[$qtd] = '/nortes/public/img/fotos/'.$id_update.'/'.$ft['id'].'.jpg';
                    $id_fotos[$qtd] = $ft;
                    $qtd++;
                }
                $hidden = 'hidden = "true" ';
                $saida = PortfolioTable::printFormulario($this->lista, $titulo, null, $id_update, $id_fotos);
            }
            
            return array(
            	'titulo' => $titulo,
            	'saida' => $saida,
            	'hidden' => $hidden,
            );
        }
    }

    public function editarAction(){
        $page=$this->params()->fromRoute("id");
        $p = (int) (isset($page)) ? ($page) : 0;
        $page = $this->paginacao($page);
        $qtd_portfolios = PortfolioTable::qtd_Portfolio();
        $t = FotosTable::consultaSql($page);
        return new ViewModel(array(
        	'portfolios' => $this->getPortfolioTable()->fetchAll($page),
        	'fotos' => $t,
                'qtd_port' => $qtd_portfolios,
                'page' => $p,
        ));
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
    
    public function paginacao($page){
        if(isset($page) && $page > 0) {
         $page = ($page * 11)+1 ;
        }
        else{
         $page = 0;
        }        
        return $page;
    }
}
