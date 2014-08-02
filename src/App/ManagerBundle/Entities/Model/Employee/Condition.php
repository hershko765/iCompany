<?php

namespace App\ManagerBundle\Entities\Model\Employee;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * App\ManagerBundle\Entities\Model\Employee
 *
 * @ORM\Table(name="employee_condition")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\Employee\Condition")
 */
class Condition extends Model
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
     * @ManyToOne(targetEntity="App\ManagerBundle\Entities\Model\Employee")
     * @JoinColumn(name="employee_id", referencedColumnName="id")
	 */
	protected $employee_id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $field;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $payment_type;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    protected $month_hours;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    protected $summed_hours;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    protected $average_hours;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return Condition
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set payment_type
     *
     * @param string $paymentType
     * @return Condition
     */
    public function setPaymentType($paymentType)
    {
        $this->payment_type = $paymentType;

        return $this;
    }

    /**
     * Get payment_type
     *
     * @return string 
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * Set month_hours
     *
     * @param integer $monthHours
     * @return Condition
     */
    public function setMonthHours($monthHours)
    {
        $this->month_hours = $monthHours;

        return $this;
    }

    /**
     * Get month_hours
     *
     * @return integer 
     */
    public function getMonthHours()
    {
        return $this->month_hours;
    }

    /**
     * Set summed_hours
     *
     * @param integer $summedHours
     * @return Condition
     */
    public function setSummedHours($summedHours)
    {
        $this->summed_hours = $summedHours;

        return $this;
    }

    /**
     * Get summed_hours
     *
     * @return integer 
     */
    public function getSummedHours()
    {
        return $this->summed_hours;
    }

    /**
     * Set average_hours
     *
     * @param integer $averageHours
     * @return Condition
     */
    public function setAverageHours($averageHours)
    {
        $this->average_hours = $averageHours;

        return $this;
    }

    /**
     * Get average_hours
     *
     * @return integer 
     */
    public function getAverageHours()
    {
        return $this->average_hours;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Condition
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
     * @return Condition
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
     * @return Condition
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
     * Set employee_id
     *
     * @param \App\ManagerBundle\Entities\Model\Employee $employeeId
     * @return Condition
     */
    public function setEmployeeId(\App\ManagerBundle\Entities\Model\Employee $employeeId = null)
    {
        $this->employee_id = $employeeId;

        return $this;
    }

    /**
     * Get employee_id
     *
     * @return \App\ManagerBundle\Entities\Model\Employee 
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
}
