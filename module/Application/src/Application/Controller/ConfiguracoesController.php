<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConfiguracoesController extends AbstractActionController {
    
     public function indexAction() {
         return new ViewModel(array(
             'saida' => null,
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
    
}