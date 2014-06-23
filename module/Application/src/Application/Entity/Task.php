<?php
namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;
    
    /**
     * @var Datetime
     *
     * @ORM\Column(name="created_at", type="datetime", length=255)
     */
    private $createdAt;
    
    /**
     * @var Datetime
     *
     * @ORM\Column(name="updated_at", type="datetime", length=255)
     */
    private $updatedAt;

    public function __construct($options = array())
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->setUpdatedAt(new \DateTime('now'));
        
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (!is_numeric($id))
            throw new \InvalidArgumentException("ID aceita apenas números inteiros");
        if ($id <= 0)
            throw new \InvalidArgumentException("ID aceita apenas números positivos");
        
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!is_bool($status))
            throw new \InvalidArgumentException("STATUS aceita apenas booleanos");
        
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        if (! is_object($createdAt))
            throw new \InvalidArgumentException("CREATEDAT aceita apenas datetime");
        if (! ($createdAt instanceof \DateTime))
            throw new \InvalidArgumentException("CREATEDAT aceita apenas datetime");
        
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        if (!is_object($updatedAt))
            throw new \InvalidArgumentException("UPDATEDAT aceita apenas datetime");
        if (get_class($updatedAt) <> 'DateTime')
            throw new \InvalidArgumentException("UPDATEDAT aceita apenas datetime");
        
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function toArray()
    {
        $hydrator = new ClassMethods();
        
        return $hydrator->extract($this);
    }
}