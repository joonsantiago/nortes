<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Login;
use Application\Model\LoginTable;
use Application\Model\Portfolio;
use Application\Model\PortfolioTable;
use Application\Model\Fotos;
use Application\Model\FotosTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sm = $e->getApplication()->getServiceManager();
        $GLOBALS['sm'] = $sm;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Application\Model\LoginTable' => function($sm){
                    $loginGateway = $sm->get('LoginTableGateway');
                    $table = new LoginTable($loginGateway);
                    return $table;
                },
                'LoginTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new Login());
                    return new TableGateway('login', $dbAdapter, null, $resultSetProtype);
                 },
                'Application\Model\PortfolioTable' => function($sm){
                     $portfolioGateway = $sm->get('PortfolioTableGateway');
                     $table = new PortfolioTable($portfolioGateway);
                     return $table;
                    },
                'PortfolioTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new Portfolio());
                    return new TableGateway('portfolio', $dbAdapter, null, $resultSetProtype);
                },
                'Application\Model\FotosTable' => function($sm) {
                	$fotosGateway = $sm->get('FotosTableGateway');
                	$table = new FotosTable($fotosGateway);
                	return $table;
                },
                'FotosTableGateway' => function($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetProtype = new ResultSet();
                	$resultSetProtype->setArrayObjectPrototype(new Fotos());
                	return new TableGateway('fotos', $dbAdapter, null, $resultSetProtype);
                }
            )
        );
    }
}
