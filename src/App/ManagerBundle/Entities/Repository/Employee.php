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
	protected $abilities = [ ];
}