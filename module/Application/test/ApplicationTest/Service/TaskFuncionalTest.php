<?php
namespace ApplicationTest\Service;

use Application\Service\Task as TaskService;
use ApplicationTest\Bootstrap;

class TaskFuncionalTest extends \PHPUnit_Framework_TestCase
{

    private $task;

    protected $em;

    public function setUp()
    {
        $this->task = new TaskService($this->getEm());
        
        $db = new \PDO("mysql:host=localhost;dbname=sonbase_test", "root", "");
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // Limpa a tabela junto com a contagem dos IDs
        $db->exec("truncate table tasks");
    }

    public function tearDown()
    {
        $this->task = NULL;
    }

    public function testVerificaSeConsegueInserirNoBD()
    {
        $data = array(
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => true
        );
        
        $result = $this->task->insert($data);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
        $this->assertEquals(1, $result->getId());
        
        $result = $this->task->insert($data);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
        $this->assertEquals(2, $result->getId());
    }

    public function testVerificaSeConsegueAlterarRegistro()
    {
        $data = array(
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => true
        );
        
        $result = $this->task->insert($data);
        
        $data = array(
            'id' => 1,
            'name' => 'Tarefa alterada',
            'description' => 'Descrição da tarefa alterada',
            'status' => true
        );
        
        $result = $this->task->update($data);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
        
        $object = $this->getEm()
            ->getRepository('Application\Entity\Task')
            ->find(1);
        
        $this->assertEquals('Tarefa alterada', $object->getName());
    }

    public function testVerificaSeConsegueDeletarRegistro()
    {
        $data = array(
            'name' => 'Tarefa24',
            'description' => 'Descrição da tarefa',
            'status' => true
        );
        
        $result = $this->task->insert($data);
        
        $id = 1;
        $result = $this->task->delete($id);
        $this->assertEquals($id, $result);
        
        $object = $this->getEm()
            ->getRepository('Application\Entity\Task')
            ->find(1);
        
        $this->assertEquals(null, $object);
    }

    /*
      @expectedException InvalidArgumentException
      @expectedExceptionMessage O registro não foi encontrado
     
    public function testRetornaErroAoDeletarRegistroInexistente()
    {
        $data = array(
            'name' => 'Tarefa Erro',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        
        $this->task->insert($data);
        
        $id = 2;
        $this->task->delete($id);
    }*/

    public function getEm()
    {
        $serviceManager = Bootstrap::getServiceManager();
        
        return $this->em = $serviceManager->get('Doctrine\ORM\EntityManager');
    }
}