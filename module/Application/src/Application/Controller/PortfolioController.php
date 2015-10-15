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

class PortfolioController extends AbstractActionController {

    public $lista = array();
    protected $portfolioTable;

    public function indexAction() {
        return new ViewModel();
    }

    public function dashboardAction() {
        
    }

    public function tituloAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $portfolio = new Portfolio();
            $data = array(
                'id' => null,
                'nome' => $request->getPost('titulo')
            );            
            $portfolio->exchangeArray($data);
            $id = $this->getPortfolioTable()->salvar($portfolio);
            
            return $this->redirect()->toUrl('add/'.$id);
        }
    }

    public function addAction() {
        $adapter = new Http();
        $destino = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/img/fotos/';
        $adapter->setDestination($destino);
        $request = $this->getRequest();
        if ($request->isPost()) {

            date_default_timezone_set('America/Sao_Paulo');
            $pasta = date("dmYHis");
            $files = $adapter->getFileInfo();

            if (!empty($files)) {
                mkdir($destino . $pasta . '/', 0777);
                $qtd = 0;
                foreach ($files as $file => $info) {
                    $adapter->addFilter('Rename', $destino . $pasta . '/' . $info['name']);
                    $adapter->receive($file);
                    $this->lista[$qtd] = '/nortes/public/img/fotos/'
                            . $pasta . '/' . $info['name'];
                    $qtd++;
                }
                $this->printFormulario($this->lista);
            }
        }
    }

    public function getPortfolioTable() {
        if (!$this->portfolioTable) {
            $sm = $this->getServiceLocator();
            $this->portfolioTable = $sm->get('Application\Model\PortfolioTable');
        }
        return $this->portfolioTable;
    }

    public function printFormulario($foto) {

        $qtd = sizeof($foto);

        print ('<section id=""> <div class="container">
                    <div class="row">');
        for ($i = 0; $i < $qtd; $i++) {
            if (($i % 2) == 0) {
                print('<div class="col-md-12 col-lg-12">
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
            </div>');
            } else {
                print('<div class="col-md-12 col-lg-12">
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
            </div>');
            }
        }

        print('<p>
                <center><a href="salvo" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Salvar postagem</a></center>
                </p>
            </div>
          </div> 
        </section>
        ');
    }

}
