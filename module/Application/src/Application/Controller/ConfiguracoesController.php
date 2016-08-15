<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Servicos;
use Application\Model\ServicosTable;

class ConfiguracoesController extends AbstractActionController {
    
    protected $servicosTable;
    protected $loginTable;
    
     public function indexAction() {
         $saida = null;
         switch ($this->params()->fromRoute("id")){
         case 1: 
             $saida = $this->salvar($this->params()->fromRoute("id"));
             break;
         }
         return new ViewModel(array(
             'saida' => $saida,
         ));
         
     }
     
     public function delServicoAction(){
         $request = $this->getRequest();
         if ($request->isPost()){
             $result = null;
             $id = $request->getPost("id-servico");
             $saida = $this->getServicos()->_delete($id);
             $hidden = 'hidden="true"';
         }else{
             $hidden = $saida = null;
             $result = $this->getServicos()->_select($this->params()->fromRoute("id"));
             foreach($result as $r){
                 $result = $r;
             }
         }
         return array(
             'hidden' => $hidden,
             'servico' => $result,
             'saida' => $saida,
         );
     }

     public function addServicoAction(){
        if($this->getLoginTable()->validarSessao()){
            $this->redirect()->toRoute('login');
        }
         $caminho = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/font-awesome-4.1.0/icons.txt';
         $listIcon = file($caminho);
         $i=0;
         $result = null;
         foreach ($listIcon as $l){
             $listIcon[$i] = trim(substr($l, 0, strpos($l, "[&#x")));
             ++$i;
         }
         if($this->params()->fromRoute("id") > 0){
             $result = $this->getServicos()->_select($this->params()->fromRoute("id"));
             foreach($result as $r){
                 $result = $r;
             }
             $result['descricao'] = str_replace( "<br />", '', $result['descricao'] );
         }
         
         return array(
             'icons' => $listIcon,
             'servico' => $result,
         );
     }
     
     public function editServicoAction(){
         $servicos = $this->getServicos()->_selectAll();
         return array(
             'servicos' => $servicos,
         );
     }
     
     public function salvar($id){
         $saida = null;
         $request = $this->getRequest();
         if ($request->isPost()){
        	$variaveis = $request->getPost();
                $servicosObj = new Servicos();
                if($variaveis['id_servico'] > 0){
                    $acao = "atualizado";
                    //$variaveis['id_servico'] = $id;
                }else{
                    $acao = "cadastrado";
                }
                $servicos = array (
                    'id' => $variaveis['id_servico'],
                    'titulo'=> $variaveis['titulo'],
                    'descricao'=> nl2br($variaveis['descricao']),
                    'faicon'=> $variaveis['faicon'],
        	);
        	$servicosObj->exchangeArray($servicos);
        	$id_servico = $this->getServicos()->_insert($servicosObj);
                $saida = ($id_servico > 0) ? $this->getServicos()->finalizarAcao($acao) : null;
         }
         return $saida;
     }
     
     public function getServicos(){
         $this->servicosTable = new ServicosTable();
         return $this->servicosTable;
    	/*if(!$this->servicosTable){
    		$sm = $this->getServiceLocator();
    		$this->servicosTable = $sm->get('Application\Model\ServicosTable');
    	}
    	return $this->servicosTable;*/
     }
     
     public function getLoginTable(){
         if (!$this->loginTable) {
            $sm = $this->getServiceLocator();
            $this->loginTable = $sm->get('Application\Model\LoginTable');
        }
        return $this->loginTable;
    } 
         
    
}