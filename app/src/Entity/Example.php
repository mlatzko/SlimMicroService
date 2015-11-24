<?php

namespace SlimMicroService\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Example
 *
 * @ORM\Table(name="example")
 * @ORM\Entity
 */
class Example
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    protected $type = 'A';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    protected $isActive = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_poweruser", type="boolean", nullable=false)
     */
    protected $isPoweruser = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    protected $age;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_fingers", type="integer", nullable=false)
     */
    protected $numberOfFingers;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    protected $modified = 'CURRENT_TIMESTAMP';


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Example
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Example
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isPoweruser
     *
     * @param boolean $isPoweruser
     *
     * @return Example
     */
    public function setIsPoweruser($isPoweruser)
    {
        $this->isPoweruser = $isPoweruser;

        return $this;
    }

    /**
     * Get isPoweruser
     *
     * @return boolean
     */
    public function getIsPoweruser()
    {
        return $this->isPoweruser;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Example
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Example
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Example
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set numberOfFingers
     *
     * @param integer $numberOfFingers
     *
     * @return Example
     */
    public function setNumberOfFingers($numberOfFingers)
    {
        $this->numberOfFingers = $numberOfFingers;

        return $this;
    }

    /**
     * Get numberOfFingers
     *
     * @return integer
     */
    public function getNumberOfFingers()
    {
        return $this->numberOfFingers;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Example
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Example
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Example
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }
}

