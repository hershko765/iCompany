<?php

namespace App\ManagerBundle\Entities\Handler\Broker;

use App\ManagerBundle\Entities\Model\Broker;
use App\SourceBundle\Base\Repository\Repository;
use App\SourceBundle\Base\HandlerManager;
use App\SourceBundle\Helpers\Arr;
use App\SourceBundle\Interfaces\Handler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator;

class Update extends HandlerManager implements Handler {

	/**
	 * @var Registry
	 * @DI (alias=doctrine)
	 */
	protected $em;

	/**
	 * @var Validator
	 * @DI (alias=validator)
	 */
	protected $validate;

	/**
	 * data to update
	 * @var array
	 */
	protected $data, $id;

	public function setData(array $data, $id = NULL)
	{
		$this->data = $data;
		$this->id = $id;
		return $this;
	}

	public function execute()
	{
		// Get repository and filter data to contain only allowed data
		$repo = $this->em->getRepository('AppManagerBundle:Model\Broker');
		// Load model by id, throw exception if nothing found
		$broker = $repo->find($this->id);
		if ( ! $broker)
			throw new NotFoundHttpException('Broker not found for id: '.$this->id);

		$repo->hydrate($this->data, $broker, Repository::PERM_UPDATE);

		// Validate model, if errors found return them
		$errors = $this->validate->validate($broker);
		if(count($errors) > 0)
		{
			return [
				'status' => FALSE,
				'errors' => $this->errorsToArr($errors)
			];
		}

        $bonusBrokerModel = new Broker();
        $bonusRepo = $this->em->getRepository('AppManagerBundle:Model\Broker', 'bonus');
        $bonusBroker = $bonusRepo->collect([ 'name' => $broker->getName() ]);
        $bonusBroker = Arr::get($bonusBroker, 0);
        if ($bonusBroker)
        {
            $bonusBrokerModel = $bonusRepo->find(Arr::get($bonusBroker, 'id'));
            $bonusRepo->hydrate($this->data, $bonusBrokerModel, Repository::PERM_UPDATE);
            $bonusRepo->save($bonusBrokerModel);
        }

		// Save model into the database and return response
		return [
			'status' => TRUE,
			'data_array' => $repo->save($broker)
		];
	}
}