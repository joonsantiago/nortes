<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Servicos;
use Application\Model\ServicosTable;

class ConfiguracoesController extends AbstractActionController {
    
    protected $servicosTable;
    
     public function indexAction() {
         $saida = $this->salvar();
         return new ViewModel(array(
             'saida' => $saida,
         ));
         
     }
     
     public function addServicoAction(){
         $caminho = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/public/font-awesome-4.1.0/icons.txt';
         $listIcon = file($caminho);
         $i=0;
         foreach ($listIcon as $l){
             $listIcon[$i] = trim(substr($l, 0, strpos($l, "[&#x")));
             ++$i;
         }
         //array_multisort($listIcon, SORT_ASC, SORT_STRING);
         //var_dump($listIcon); die;
         
         return array(
             'icons' => $listIcon,
         );
     }
     
     public function salvar(){
         $saida = null;
         $request = $this->getRequest();
         if ($request->isPost()){
        	$variaveis = $request->getPost();
                $servicosObj = new Servicos();
                $servicos = array (
                    'id' => $variaveis['id_servico'],
                    'titulo'=> $variaveis['titulo'],
                    'descricao'=> $variaveis['descricao'],
                    'faicon'=> $variaveis['faicon'],
        	);
        	$servicosObj->exchangeArray($servicos);
        	$id_servico = $this->getServicos()->_insert($servicosObj);
                $saida = ($id_servico > 0) ? $this->getServicos()->finalizarAcao("cadastrado") : null;
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
         
    
}