<?php
namespace App\ManagerBundle\Entities\Repository;

use App\SourceBundle\Base\Repository\Repository;
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
        [ 'deleted', 'deleted', '=' ]
    ];

	/**
	 * List of table fields
	 * @var array
	 */
	protected $tableMap = [
		'id'         => [ 'varchar', self::PERM_NONE   ],
		'first_name' => [ 'varchar', self::PERM_ALL    ],
		'last_name'  => [ 'varchar', self::PERM_ALL    ],
		'email'      => [ 'varchar', self::PERM_CREATE ],
	];

	/**
	 * Model abilities
	 *
	 * @var array
	 */
	protected $abilities = [ ];
}