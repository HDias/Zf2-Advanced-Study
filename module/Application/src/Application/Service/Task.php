<?php
namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Application\Entity\Task as TaskEntity;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Zend\Stdlib\Hydrator\ClassMethods;

class Task
{

    private $em;

    function __construct(EntityManager $em = null)
    {
        $this->em = $em;
    }

    public function getEm()
    {
        return $this->em;
    }
    
    /*
     * public function truncate() { $query = $this->getEm()->createQuery('TRUNCATE TABLE tasks'); $query->getResult(); }
     */
    public function insert(array $data)
    {
        $entity = new TaskEntity($data);
        $this->getEm()->persist($entity);
        $this->getEm()->flush();
        
        return $entity;
    }

    public function update(array $data)
    {
        if (! isset($data['id']))
            throw new \InvalidArgumentException('A key ID é obrigatoria no array');
        
        $entity = $this->getEm()->getReference('Application\Entity\Task', $data['id']);
        $hydrator = new ClassMethods();
        $hydrator->hydrate($data, $entity);
        
        $this->getEm()->persist($entity);
        $this->getEm()->flush();
        
        return $entity;
    }

    public function delete($id)
    {
        if (! is_numeric($id))
            throw new InvalidArgumentException('O campo ID deve ser numérico');
        
        $entity = $this->getEm()->getReference('Application\Entity\Task', $id);
        
        /*if($entity == null)
            throw new InvalidArgumentException('O registro não foi encontrado');*/
        
        $this->getEm()->remove($entity);
        $this->getEm()->flush();
        
        return $id;
    }
}








