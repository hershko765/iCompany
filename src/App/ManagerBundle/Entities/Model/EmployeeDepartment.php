<?php

namespace App\ManagerBundle\Entities\Model;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\ManagerBundle\Entities\Model\EmployeeDepartment
 *
 * @ORM\Table(name="employee_department")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\EmployeeDepartment")
 */
class EmployeeDepartment extends Model
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
     * Set employee_id
     *
     * @param integer $employeeId
     * @return EmployeeDepartment
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
     * @return EmployeeDepartment
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
