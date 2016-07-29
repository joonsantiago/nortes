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
    
}