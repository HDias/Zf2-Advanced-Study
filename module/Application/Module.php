<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    
    
    //Configuração Cache
    public function getServiceConfig(){
        return array(
        	'factories' => array(
        	   'Cache' => function($sm){
        	       
        	       //Recuperar configuração no global.php
        	       $config = $sm->get('config');
        	       
        	       $cache = StorageFactory::factory(array(
        	           'adapter' => array(
        	           		'name'    => $config['cache']['adapter'], //alternative php cache
        	           		'options' => array(
        	           		    'ttl' => $config['cache']['ttl']//time to live
        	           		), 
        	           ),
        	           'plugins' => array(
        	               //Mostra se houve algum tipo de erro na geração do cache
        	               //Em produção usar true
        	           	   'exception_handler' => array('throw_exceptions' => true),
        	               //Serializa pra que seja guardado  
        	               'serializer'
        	           ),
        	       ));
        	       return $cache;
        	   },
        	   'MemCached' => function($sm){
        	   	$cache = StorageFactory::factory(array(
        	   			'adapter' => array(
        	   					'name'    => 'Memcached', 
        	   					'options' => array(
        	   					    'ttl' => 10,
        	   					    //servidores
        	   					    'servers' => array(
        	   					        //aqui no caso é na maquina local, Porta
        	   					        array('127.0.0.1', 11211)
        	   					        )
        	   					), 
        	   			),
        	   			'plugins' => array(
        	   		          'serializer',
        	   			      'exception_handler' => array('throw_exceptions' => true),
        	   			),
        	   	));
        	   	return $cache;
        	   }
            )
        );
    }
}
