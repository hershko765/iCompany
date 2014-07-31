<?php

namespace App\ManagerBundle\Entities\Model;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * App\ManagerBundle\Entities\Model\Company
 *
 * @ORM\Table(name="company")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\Company")
 * @UniqueEntity("email")
 * @UniqueEntity("phone")
 */
class Company extends Model
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

	/**
	 * @var string
     * @Assert\NotBlank()
	 * @ORM\Column(type="string", length=80)
	 */
	protected $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $logo;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    protected $size;

    /**
     * @var object
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    protected $created;

    /**
     * @var object
     * @ORM\Column(type="datetime")
     */
    protected $modified;

    /**
     * @var object
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deleted;




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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set title
     *
     * @param string $title
     * @return Company
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Company
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Company
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Company
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
     * @return Company
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

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Company
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
