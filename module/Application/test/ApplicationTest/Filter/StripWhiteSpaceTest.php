<?php
namespace ApplicationTest\Filter;

use Application\Filter\StripWhiteSpace;
use Zend\Filter\StringTrim;
/*
 * Remover Espaço em branco
 */
class StripWhiteSpaceTest extends \PHPUnit_Framework_TestCase
{

    public function testVerificaSeClasseDoFiltroExiste()
    {
        /*
         * Resulta em Skipped: 1. se a classe naõ existir
         */
        if (! class_exists('Application\Filter\StripWhiteSpace'))
            $this->markTestSkipped("Classe não existe");
    }

    public function testVerificaSeClasseHerdaDeAbstractFilter()
    {
        $this->assertInstanceOf('Zend\Filter\AbstractFilter', new StripWhiteSpace());
    }

    public function testVerificaSeFiltroEstaRemovendoEspacosEmBrancoAdiconais()
    {
        $phrase = "Olá        Horecio";
        
        $filtro = new StripWhiteSpace();
        $result = $filtro->filter($phrase);
        
        $this->assertEquals("Olá Horecio", $result);
        
        //Esse filtro abaixo já faz o que o filtro acima propõe e muito mais
        $filtro = new StringTrim();
        $filtro->filter($phrase);
        
    }
}