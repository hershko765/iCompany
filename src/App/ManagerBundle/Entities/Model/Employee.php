<?php

namespace App\ManagerBundle\Entities\Model;

use App\SourceBundle\Base\Model;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\ManagerBundle\Entities\Model\Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\ManagerBundle\Entities\Repository\Employee")
 */
class Employee extends Model
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
	 * @ORM\Column(type="string", length=80)
	 */
	protected $first_name;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $last_name;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $email;

}
