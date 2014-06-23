<?php
namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class PrimeNumber extends AbstractValidator
{

    const NOT_PRIME = 'notPrime';

    protected $messageTemplates = array(
        self::NOT_PRIME => "Esse não é um número Primo"
    );

    public function isValid($value)
    {
        if (! is_numeric($value) || $value <= 0) {
            $this->error(self::NOT_PRIME);
            return false;
        }
        
        $result = true;
        $aux = 2;
        while ($aux < $value) {
            if ($value % $aux == 0)
                $result = false;
            
            $aux ++;
        }
        if (! $result)
            $this->error(self::NOT_PRIME);
        
        return $result;
    }
}