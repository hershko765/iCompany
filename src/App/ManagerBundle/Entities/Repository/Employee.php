<?php
namespace App\ManagerBundle\Entities\Repository;

use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Helpers\Arr;
use Doctrine\ORM\QueryBuilder;

class Employee extends Repository {

	protected $tableName    = 'employees';
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
		'id'         => [ 'varchar', self::PERM_NONE   ],
		'first_name' => [ 'varchar', self::PERM_ALL    ],
		'last_name'  => [ 'varchar', self::PERM_ALL    ],
		'email'      => [ 'varchar', self::PERM_ALL    ],
        'phone'      => [ 'varchar', self::PERM_ALL    ],
        'password'   => [ 'varchar', self::PERM_ALL    ],
        'company_id' => [ 'varchar', self::PERM_ALL    ],
        'created'    => [ 'varchar', self::PERM_ALL    ],
        'modified'   => [ 'varchar', self::PERM_ALL    ],
        'deleted'    => [ 'varchar', self::PERM_ALL    ]
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