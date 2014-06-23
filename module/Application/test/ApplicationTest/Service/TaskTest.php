<?php
namespace ApplicationTest\Service;

use Application\Service\Task;
use Application\Entity\Task as TaskEntity;
use ApplicationTest\Bootstrap;

class TaskTest extends \PHPUnit_Framework_TestCase
{

    private $task;

    protected $em;

    public function setUp()
    {
        $this->task = new Task();
    }

    public function tearDown()
    {
        $this->task = NULL;
    }

    public function testVerificaSeClasseTaskExiste()
    {
        $class = class_exists("Application\Service\Task");
        $this->assertTrue($class);
    }

    public function testVerificaSeAClasseTemOAtributoEm()
    {
        $this->assertClassHasAttribute('em', 'Application\Service\Task');
    }

    public function testVerificaMetodoGetEm()
    {
        /*
         * $this->task = new Task($this->getEm()); $em = $this->task->getEm();
         */
        $this->task = new Task($this->getEmMock());
        $em = $this->task->getEm();
        
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $em);
    }

    public function testVerificaInsertInBD()
    {
        $this->task = new Task($this->getEmMock());
        $data = array(
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        $result = $this->task->insert($data);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage A key ID é obrigatoria no array
     */
    public function testVerificaSeIdEstaNoArrayDoUpdate()
    {
        $this->task = new Task($this->getEmMock());
        $data = array(
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        $result = $this->task->update($data);
    }

    public function testVerificaRetornoDoUpdate()
    {
        $data = array(
            'id' => 1,
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        
        // usamos o getReference do doctrine então:
        $emMock = $this->getEmMock($data);
        $emMock->expects($this->any())
            ->method('getReference')
            ->will($this->returnValue(new TaskEntity($data)));
        
        $this->task = new Task($emMock);
        $result = $this->task->update($data);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage O campo ID deve ser numérico
     */
    public function testVerificaSeRetornaErroSeIdNaoForNumerico()
    {
        $this->task = new Task($this->getEmMock());
        
        $result = $this->task->delete('Abc');
    }

    /*
      @expectedException InvalidArgumentException
      @expectedExceptionMessage O registro não foi encontrado
     
    public function testVerificaSeRetornaErroSeOIdNaoforEncontrado()
    {
        $this->task = new Task($this->getEmMock());
        
        $data = array(
            'id' => 1,
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        $this->task->insert($data);
        
        $this->task->delete(2);
    }*/

    public function testVerificaRetornoDoMetodoDelete()
    {
        $data = array(
            'id' => 1,
            'name' => 'Tarefa1',
            'description' => 'Descrição da tarefa',
            'status' => false
        );
        $emMock = $this->getEmMock($data);
        
        $emMock->expects($this->any())
            ->method('getReference')
            ->will($this->returnValue(new TaskEntity($data)));
        
        $this->task = new Task($emMock);
        
        $this->assertEquals(1, $this->task->delete(1));
        $this->assertEquals(2, $this->task->delete(2));
    }
    
    /*
     * Mock do entityManager
     */
    private function getEmMock()
    {
        $emMock = $this->getMock('Doctrine\ORM\EntityManager', array(
            'persist',
            'flush',
            'getReference',
            'remove'
        ), array(), '', false);
        // quando persist for executado vai retornar null
        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        
        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));
        
        $emMock->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(null));
        
        return $emMock;
    }
}