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
use Application\Model\Login;
use Zend\Session\Container;

class IndexController extends AbstractActionController {

    protected $loginTable;

    public function indexAction() {
        return new ViewModel();
    }

    public function sobreAction() {
        
    }

    public function contatoAction() {
        
    }

    public function timeAction() {
        
    }

    public function loginAction() {
        
        $sessao = new Container();
        $id = $this->params()->fromRoute("id") ? ($this->params()->fromRoute("id")) : null;
        $request = $this->getRequest();
        if(empty($sessao->usuario)){
            if ($request->isPost()) {
                $senha = $request->getPost('senha');
                $usuario = $request->getPost('usuario');

                if(!empty($senha) && !empty($usuario)){
                    $user = new Login();
                    $user = $this->getLoginTable()->getLogin($usuario,$senha);

                    if(!$user){
                        $this->redirect()->toRoute('errologin');
                    }else{
                        $sessao->usuario = $usuario;
                        $sessao->registro = time();
                         $this->redirect()->toRoute('dashboard');
                    }
                }
            }
        }else{
            if(!isset($id)){
                $this->redirect()->toRoute('dashboard');
            }else{
                $sessao->getManager()->getStorage()->clear();
                $this->redirect()->toRoute('login');
            }
        }
    }
    
    public function errologinAction() {
        
    }
    
    public function getLoginTable(){
         if (!$this->loginTable) {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('Application\Model\LoginTable');
        }
        return $this->loginTable;
    }
    

}
