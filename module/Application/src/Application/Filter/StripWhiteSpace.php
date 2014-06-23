<?php
namespace Application\Filter;

use Zend\Filter\AbstractFilter;

class StripWhiteSpace extends AbstractFilter
{

    public function filter($value)
    {
        //sempre que encontrar um espaço seguido de um ou mais espaço coloca somente um espçao
    	return preg_replace('/\s\s+/', ' ', $value);
    }
}