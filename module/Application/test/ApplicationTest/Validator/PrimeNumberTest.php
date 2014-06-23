<?php
namespace ApplicationTest\Validator;

use Application\Validator\PrimeNumber;

class PrimeNumberTest extends \PHPUnit_Framework_TestCase
{

    public function testVerificaSeClasseDoFiltroExiste()
    {
        /*
         * Resulta em Skipped: 1. se a classe naõ existir
         */
        if (! class_exists('Application\Validator\PrimeNumber'))
            $this->markTestSkipped("Classe não existe");
    }

    public function testVerificaSeClasseHerdaDeAbstractValidator()
    {
        $this->assertInstanceOf('Zend\Validator\AbstractValidator', new PrimeNumber());
    }

    public function testVerificaSeNaoENumero()
    {
        $class = new PrimeNumber();
        $result = $class->isValid('ABc');
        
        $this->assertFalse($result);
        
        $result = $class->isValid(1);
        $this->assertTrue($result);
    }

    public function testVerificaSeNumeroEMenorQue1()
    {
        $class = new PrimeNumber();
        $result = $class->isValid(0);
        
        $this->assertFalse($result);
        
        $result = $class->isValid(- 1);
        
        $this->assertFalse($result);
    }
    
    public function dataProviderPrime()
    {
        return array(
        	array(2),
            array(3),
            array(13)
        );
    }
    
    public function dataProviderNotPrime()
    {
    	return array(
    			array(6),
    			array(10),
    			array(12),
    	);
    }
    /**
     * @dataProvider dataProviderPrime
     */
    public function testVerificaSeORestoDaDivisaoEntre2EONumeroEIgualA0($number)
    {
        $class = new PrimeNumber();
        $result = $class->isValid($number);
        
        $this->assertTrue($result);
    }
    
    /**
     * @dataProvider dataProviderNotPrime
     */
    public function testVerificaSeORestoDaDivisaoEntre2EONumeroEDiferenteDe0($number)
    {
    	$class = new PrimeNumber();
    	$result = $class->isValid($number);
    
    	$this->assertFalse($result);
    }
    
    public function testVerificaMensagemDeErroQuandoNumeroNaoEPrimo()
    {
        $class = new PrimeNumber();
        $result = $class->isValid(10);
        
        $this->assertArrayHasKey('notPrime', $class->getMessages());
        $this->assertEquals('Esse não é um número Primo', $class->getMessages()['notPrime']);
    }
}