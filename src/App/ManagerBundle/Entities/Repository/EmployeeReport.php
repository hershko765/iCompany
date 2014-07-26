<?php
namespace App\ManagerBundle\Entities\Repository;

use App\SourceBundle\Base\Repository\Repository;
use Doctrine\ORM\QueryBuilder;

class EmployeeReport extends Repository {

	protected $tableName    = 'employee_report';
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
		'employee_id'=> [ 'varchar', self::PERM_ALL    ],
		'start_date' => [ 'varchar', self::PERM_ALL    ],
		'end_date'   => [ 'varchar', self::PERM_ALL    ],
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