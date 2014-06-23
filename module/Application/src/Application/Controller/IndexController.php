<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{   
    public function indexAction()
    {   
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository('Application\Entity\Task');
        
        $task = $repository->findAll();
        
        return new ViewModel(
	       array(
                'tasks' => $task
            )   
        );
    }
    
    public function articleAction()
    {
        /* $page = $this->params()->fromRoute('id');
        $page2 = $this->params()->fromRoute('name');
        echo "ArticleAction <br>";
        echo "ID {$page} e {$page2} <br>"; */
        
        return new ViewModel(
        );
    }
}
