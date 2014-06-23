<?php
namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Service\Task;
use ApplicationTest\Bootstrap;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\MvcEvent;

class IndexControllerTest extends AbstractHttpControllerTestCase
{

    protected $traceError = true;

    protected $em;

    public function setUp()
    {
        $db = new \PDO("mysql:host=localhost;dbname=sonbase_test", "root", "");
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // Limpa a tabela junto com a contagem dos IDs
        $db->exec("truncate table tasks");
        
        $serviceManager = Bootstrap::getServiceManager();
        $this->em = $serviceManager->get('Doctrine\ORM\EntityManager');
        
        $this->setApplicationConfig(include '\config\application.config.php');
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/application');
        
        $this->assertResponseStatusCode(200);
        
        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertActionName('index');
        $this->assertMatchedRouteName('application');
    }

    public function testErro404()
    {
        $this->dispatch('/nenhuma');
        $this->assertResponseStatusCode(404);
    }

    public function testIndexAction()
    {
        $class = new Task($this->em);
        
        $data = array(
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        $class->insert($data);
        
        $data['name'] = 'Tarefa 2';
        $class->insert($data);
        
        $this->dispatch('/application');
        $this->assertActionName('index');
        $this->assertResponseStatusCode(200);
    }
}

?>