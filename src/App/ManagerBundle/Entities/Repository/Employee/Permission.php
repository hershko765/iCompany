<?php
namespace App\ManagerBundle\Entities\Repository\Employee;

use App\SourceBundle\Base\Repository\Repository;
use Doctrine\ORM\QueryBuilder;

class Permission extends Repository {

	protected $tableName    = 'employee_permission';
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
		'employee_id'   => [ 'varchar', self::PERM_ALL    ],
		'department_id' => [ 'varchar', self::PERM_ALL    ],
		'entity_id'     => [ 'varchar', self::PERM_ALL    ],
        'handlers'      => [ 'varchar', self::PERM_ALL    ],
        'created_by'    => [ 'varchar', self::PERM_ALL    ],
        'modified_by'   => [ 'varchar', self::PERM_ALL    ],
        'created'       => [ 'varchar', self::PERM_ALL    ],
        'modified'      => [ 'varchar', self::PERM_ALL    ],
        'deleted'       => [ 'varchar', self::PERM_ALL    ]
	];

	/**
	 * Model abilities
	 *
	 * @var array
	 */
	protected $abilities = [ ];
}