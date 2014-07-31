<?php
namespace App\ManagerBundle\Entities\Repository\Employee;

use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Helpers\Arr;
use Doctrine\ORM\QueryBuilder;

class Condition extends Repository {

	protected $tableName    = 'employee_condition';
    protected $defaultOrder = 'ASC';
    protected $defaultSort  = 'id';

    /**
	 * Entity available filters
	 *
	 * [ <Filter Name>, <Related Column>, <Mysql Operator>
	 * @var array
	 */
	protected $filterMap = [
        [ 'search', [ 'email', 'first_name', 'last_name' ], 'LIKE' ],
        [ 'email', 'email', '=' ],
        [ 'login', 'custom', 'custom' ],
        [ 'deleted', 'deleted', '=' ],
    ];

	/**
	 * List of table fields
	 * @var array
	 */
	protected $tableMap = [
		'id'           => [ 'varchar', self::PERM_NONE   ],
		'employee_id'  => [ 'varchar', self::PERM_ALL    ],
		'field'        => [ 'varchar', self::PERM_ALL    ],
		'payment_type' => [ 'varchar', self::PERM_ALL    ],
        'month_hours'  => [ 'varchar', self::PERM_ALL    ],
        'summed_hours' => [ 'varchar', self::PERM_ALL    ],
        'average_hours'=> [ 'varchar', self::PERM_ALL    ],
        'created'      => [ 'varchar', self::PERM_ALL    ],
        'modified'     => [ 'varchar', self::PERM_ALL    ],
        'deleted'      => [ 'varchar', self::PERM_ALL    ]
	];

	/**
	 * Model abilities
	 *
	 * @var array
	 */
	protected $abilities = [ self::UPDATABLE, self::CREATABLE ];

    protected function filterLogin(QueryBuilder $qb, $value)
    {
        $email    = Arr::get($value, 'email');
        $password = Arr::get($value, 'password');

        $qb->andWhere('entity.email = :email');
        $qb->andWhere('entity.password = :password');
        $qb->setParameters([
           'email'    => $email,
           'password' => $password
        ]);

    }
}