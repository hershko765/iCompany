<?php

namespace App\ManagerBundle\Entities\Model;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\ManagerBundle\Entities\Model\EmployeePermission
 *
 * @ORM\Table(name="employee_permission")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\EmployeePermission")
 */
class EmployeePermission extends Model
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
	/**
	 * @var integer
	 * @ORM\Column(type="integer")
	 */
	protected $employee_id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $department_id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $entity_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $handlers;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $created_by;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $modified_by;

    /**
     * @var object
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var object
     * @ORM\Column(type="datetime")
     */
    protected $modified;

    /**
     * @var object
     * @ORM\Column(type="datetime")
     */
    protected $deleted;






    /**
     * Set employee_id
     *
     * @param integer $employeeId
     * @return EmployeePermission
     */
    public function setEmployeeId($employeeId)
    {
        $this->employee_id = $employeeId;

        return $this;
    }

    /**
     * Get employee_id
     *
     * @return integer 
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Set department_id
     *
     * @param integer $departmentId
     * @return EmployeePermission
     */
    public function setDepartmentId($departmentId)
    {
        $this->department_id = $departmentId;

        return $this;
    }

    /**
     * Get department_id
     *
     * @return integer 
     */
    public function getDepartmentId()
    {
        return $this->department_id;
    }

    /**
     * Set entity_id
     *
     * @param integer $entityId
     * @return EmployeePermission
     */
    public function setEntityId($entityId)
    {
        $this->entity_id = $entityId;

        return $this;
    }

    /**
     * Get entity_id
     *
     * @return integer 
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * Set handlers
     *
     * @param string $handlers
     * @return EmployeePermission
     */
    public function setHandlers($handlers)
    {
        $this->handlers = $handlers;

        return $this;
    }

    /**
     * Get handlers
     *
     * @return string 
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Set created_by
     *
     * @param string $createdBy
     * @return EmployeePermission
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set modified_by
     *
     * @param string $modifiedBy
     * @return EmployeePermission
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modified_by = $modifiedBy;

        return $this;
    }

    /**
     * Get modified_by
     *
     * @return string 
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeePermission
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
     * @return EmployeePermission
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
     * @return EmployeePermission
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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
