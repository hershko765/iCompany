<?php
namespace App\UserBundle\Entities\Repository;

use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Helpers\Arr;
use Doctrine\ORM\QueryBuilder;

class User extends Repository {

	protected $tableName = 'users';

	/**
	 * Entity available filters
	 *
	 * [ <Filter Name>, <Related Column>, <Mysql Operator>
	 * @var array
	 */
	protected $filterMap = [
		[ 'search', 'full_name', 'LIKE' ],
		[ 'login', 'custom', 'custom' ],
	];

	/**
	 * List of table fields
	 * @var array
	 */
	protected $tableMap = [
		'id'        => [ 'varchar',  self::PERM_NONE   ],
		'email'     => [ 'varchar',  self::PERM_ALL    ],
		'firstname' => [ 'text',     self::PERM_ALL    ],
		'lastname'  => [ 'text',     self::PERM_ALL    ],
		'password'  => [ 'text',     self::PERM_CREATE ],
	];

	/**
	 * Model abilities
	 *
	 * @var array
	 */
	protected $abilities = [ ];

	public function filterLogin(QueryBuilder $qb, $value)
	{
		$qb->andWhere('entity.email = :email');

		$qb->setParameter('email', Arr::get($value, 'email'));
	}
}