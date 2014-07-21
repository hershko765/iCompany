<?php
namespace App\ManagerBundle\Entities\Repository;

use App\SourceBundle\Base\Repository\Repository;
use Doctrine\ORM\QueryBuilder;

class Broker extends Repository {

	protected $tableName = 'brokers';
    protected $defaultOrder = 'ASC';
    protected $defaultSort = 'display_name';

    /**
	 * Entity available filters
	 *
	 * [ <Filter Name>, <Related Column>, <Mysql Operator>
	 * @var array
	 */
	protected $filterMap = [
		[ 'name', 'name', '=' ],
		[ 'search', ['name', 'display_name' ], 'LIKE' ],
		[ 'active', 'active', '=' ],
		[ 'blocked', 'blocked', 'custom' ],
	];

	/**
	 * List of table fields
	 * @var array
	 */
	protected $tableMap = [
		'id'             => [ 'varchar', self::PERM_NONE ],
		'name'           => [ 'varchar', self::PERM_CREATE ],
		'display_name'   => [ 'varchar', self::PERM_ALL  ],
		'reg_url'        => [ 'varchar', self::PERM_ALL  ],
		'login_url'      => [ 'varchar', self::PERM_ALL  ],
		'redirect_param' => [ 'varchar', self::PERM_ALL  ],
		'thanku_url'     => [ 'varchar', self::PERM_ALL  ],
		'deposit_url'    => [ 'varchar', self::PERM_ALL  ],
		'regulated'      => [ 'int',     self::PERM_ALL  ],
		'captcha'        => [ 'int',     self::PERM_ALL  ],
        'limit_ip'       => [ 'int',     self::PERM_ALL  ],
        'bottom_injects' => [ 'varchar', self::PERM_ALL  ],
        'comments'       => [ 'varchar', self::PERM_ALL  ],
        'api_username'   => [ 'varchar', self::PERM_ALL  ],
        'api_password'   => [ 'varchar', self::PERM_CREATE ],
        'api_url'        => [ 'varchar', self::PERM_ALL  ],
        'logo_link'      => [ 'varchar', self::PERM_ALL  ],
        'home_url'       => [ 'varchar', self::PERM_ALL  ],
        'token'          => [ 'varchar', self::PERM_ALL  ],
        'trade_url'      => [ 'varchar', self::PERM_ALL  ],
        'campaign_id'    => [ 'int',     self::PERM_ALL  ],
        'active'         => [ 'int',     self::PERM_ALL  ],
        'streamer_url'   => [ 'varchar', self::PERM_ALL  ],
        'regulated_status' => [ 'varchar', self::PERM_ALL  ],
        'spotoption_broker_name' => [ 'text', self::PERM_ALL  ],
	];

	/**
	 * Model abilities
	 *
	 * @var array
	 */
	protected $abilities = [ self::MULTI_DB ];
}