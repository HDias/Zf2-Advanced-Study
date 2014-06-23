<?php
namespace ApplicationTest\Entity;

use Application\Entity\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    private $task;
    
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
        $class = class_exists("Application\Entity\Task");
        $this->assertTrue($class);
    }

    public function dataProviderAtributes()
    {
        return array(
            array(
                'id',
                1
            ),
            array(
                'name',
                'Task name'
            ),
            array(
                'description',
                'Task Description'
            ),
            array(
                'status',
                false
            ),
            array(
                'createdAt',
                new \DateTime()
            ),
            array(
                'updatedAt',
                new \DateTime()
            )
        );
    }

    /**
     * @dataProvider dataProviderAtributes
     */
    public function testVerificaSeAClasseTemOsAtributosEsperados($atributes)
    {
        $this->assertClassHasAttribute($atributes, 'Application\Entity\Task');
    }

    /**
     * @dataProvider dataProviderAtributes
     */
    public function testVerificaSeClassePossuiGetESetDosAtributos($atributes, $value)
    {
        $get = 'get' . ucfirst($atributes);
        
        $set = 'set' . ucfirst($atributes);
        
        $this->task->$set($value);
        
        $this->assertEquals($value, $this->task->$get());
    }

    /**
     * @dataProvider dataProviderAtributes
     */
    public function testVerificaInterfaceFluenteNosSets($atribites, $value)
    {
        $set = 'set' . ucfirst($atribites);
        
        // $result recebe a própria classe (return $this)
        $result = $this->task->$set($value);
        
        $this->assertInstanceOf('Application\Entity\Task', $result);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ID aceita apenas números inteiros
     */
    public function testVerificaSeRecebeErroSeIdNaoForInteiro()
    {
        $this->task->setId('ABc');
    }
    
    public function dataProviderNumberMaiorQueZero()
    {
    	return array(
    	   array(0),
    	   array(-1),
    	);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ID aceita apenas números positivos
     * @dataProvider dataProviderNumberMaiorQueZero
     */
    public function testVerificaSeRecebeErroSeIdForMenorQueUm($number)
    {
        $this->task->setId($number);
    }
    
    public function dataProviderStringAndNumber()
    {
    	return array(
    			array('Abc'),
    			array(1),
    	);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage STATUS aceita apenas booleanos
     * @dataProvider dataProviderStringAndNumber
     */
    public function testVerificaSeRecebeErroSeStatusForDiferenteDeBoolean($value)
    {
    	
    	$this->task->setStatus($value);
    }
    
    public function dataProviderStringAndObject()
    {
    	return array(
    			array('Abc'),
    			array(new Task()),
    	);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage CREATEDAT aceita apenas datetime
     * @dataProvider dataProviderStringAndObject
     */
    public function testVerificaSeRecebeErroSeCreatedatForDiferenteDeDatetime($value)
    {
        //está aceitando outros tipos de objetos
    	$this->task->setCreatedAt($value);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage UPDATEDAT aceita apenas datetime
     */
    public function testVerificaSeRecebeErroSeUpdatedatForstringENaoDatetime()
    {
    	$this->task->setUpdatedAt('ABc');
    }
    
    public function testVerificaSeCreatedatEupdatedAtEstaoSendoInicializados()
    {
        $this->assertInstanceOf("\DateTime", $this->task->getCreatedAt());
        $this->assertInstanceOf("\DateTime", $this->task->getUpdatedAt());
    }
    
    public function testVerificaMetodoToarray()
    {
        $this->task->setId(1)
            ->setName('Tarefa1')
            ->setDescription('Descrição da Tarefa')
            ->setStatus(true);
        
        $result = $this->task->toArray();
        
        $array = array(
        	'id' => 1,
            'name' => 'Tarefa1',
            'description' => 'Descrição da Tarefa',
            'status' => true,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        );
        
        $this->assertEquals($result, $array);
    }
    
    public function testVerificaHydratorNoConstrutor()
    {
        $array = array(
        		'id' => 1,
        		'name' => 'Tarefa1',
        		'description' => 'Descrição da Tarefa',
        		'status' => true,
        		'created_at' => new \DateTime(),
        		'updated_at' => new \DateTime()
        );
        
        $this->task = new Task($array);
        
        $this->assertEquals($array, $this->task->toArray());
        
    }
}

