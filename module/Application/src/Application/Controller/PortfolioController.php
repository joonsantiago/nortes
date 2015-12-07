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

class PortfolioController extends AbstractActionController {

    public $lista = array();
    protected $portfolioTable;

    public function indexAction() {
        return new ViewModel();
    }

    public function dashboardAction() {
        $request = $this->getRequest();
        if ($request->isPost()){
        	$saida = '
				     <div class="container">
				        <div class="row">
				            <div class="col-md-4 text-center"></div>
				            <div class="col-md-4 text-center">
				                <div class="alert alert-success fade in">
				                    <a href="#" class="close" data-dismiss="alert">&times;</a>
				                    <strong>Concluído:</strong> Portfólio cadastrado com sucesso.
				                </div>
				
				            </div>
				        </div>
				    </div>';
        	
        	return array(
        		'saida' => $saida,
        	);
        }
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

}
