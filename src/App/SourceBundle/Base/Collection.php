<?php

namespace App\SourceBundle\Base;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection {

	public function asArray()
	{
		$resultArr = [];
		foreach($this->$this->_elements as $el)
		{
			$resultArr[] = (array) $el;
		}

		return $resultArr;
	}
}