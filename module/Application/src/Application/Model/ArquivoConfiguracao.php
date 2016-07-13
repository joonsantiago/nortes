<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;

class ArquivoConfiguracao{
    
    protected $adapter = 0;
    
    public function ConfAdapter() {
            $this->adapter = new Adapter(array(
               'driver' => 'Mysqli',
               'database' => 'douglas',
               'username' => 'root',
               'password' => '',
               'charset' => 'utf8',
            ));
         return $this->adapter;
    }
}