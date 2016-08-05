<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            
            'dashboard' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'dashboard',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'dashboard',
                            ),
                        ),
                    ),
                ),
            ),
            
            'errologin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/errologin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'errologin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'errologin',
                            ),
                        ),
                    ),
                ),
            ),
                                   
            'login' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'login',
                            ),
                        ),
                    ),
                ),
            ),
            
            'time' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/time',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'time',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'time',
                            ),
                        ),
                    ),
                ),
            ),
            
            'contato' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/contato',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'contato',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'contato',
                            ),
                        ),
                    ),
                ),
            ),
            
            'sobre' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/sobre',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'sobre',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'sobre',
                            ),
                        ),
                    ),
                ),
            ),
            //application
            'inicio' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/inicio',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            
            //ASSIM SE CONFIGURA UMA ROTA GERAL
            'portfolio' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/portfolio',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                
                //UMA ROTA FILHA DA GERAL DEVE-SE SER CONFIGURADA AQUI child_routes
                'child_routes' => array(
                    //EXISTE AQUI A ROTA PADRÃO, O TIPO, E SEU ENDEREÇO NA URL APÓS O CONTROLLER "Portfolio"
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id][/:nome][/:idfoto]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            //AQUI SE INDICA O CONTROLLER E ACTION PADRÃO DESSA ROTA, ACIMA DE ESCREVE QUAIS CARACTERES SE ACEITAM
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    //NOME DA ROTA PADRÃO "add"                    
                    'add' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            //SUA SUBROTA "portfolio/add"
                            'route'    => '/add',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            //SEUS VALORES PADRÕES DE CONTROLLER E ACTION
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'add',
                            ),
                        ),
                    ), 
                    //NOME DA ROTA PADRÃO "add"                    
                    'titulo' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            //SUA SUBROTA "portfolio/add"
                            'route'    => '/titulo[/:id][/:nome]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            //SEUS VALORES PADRÕES DE CONTROLLER E ACTION
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'titulo',
                            ),
                        ),
                    ),
                     
                    //NOME DA ROTA PADRÃO "add"                    
                    'editar-portfolio' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            //SUA SUBROTA "portfolio/add"
                            'route'    => '/editar-portfolio[/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            //SEUS VALORES PADRÕES DE CONTROLLER E ACTION
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'editar',
                            ),
                        ),
                    ),
                    
                    //NOME DA ROTA PADRÃO "add"                    
                    'apagar-portfolio' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            //SUA SUBROTA "portfolio/add"
                            'route'    => '/apagar-portfolio[/:id][/:nome][/:idfoto]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            //SEUS VALORES PADRÕES DE CONTROLLER E ACTION
                            'defaults' => array(
                                'controller' => 'Portfolio',
                                'action' => 'deletar',
                            ),
                        ),
                    ),
                ),
            ),
            
            //configuracoes
            'configuracoes' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/configuracoes',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Configuracoes',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Configuracoes',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    
                    'add-servico' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/add-servico[/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Configuracoes',
                                'action' => 'addServico',
                            ),
                        ),
                    ),
                ),
            ),
            
            
        ),
    ),
    
    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => Controller\IndexController::class,
            'Application\Controller\Portfolio' => Controller\PortfolioController::class,
            'Application\Controller\Configuracoes' => Controller\ConfiguracoesController::class,
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
