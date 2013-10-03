<?php namespace Rtablada\EloquentActsAsList;

trait ActsAsList {
	/**
	 * Column used for model list positions
	 * @var string
	 */
	protected $positionColumn = 'position';

	/**
	 * Position for the first element in a list
	 * @var integer
	 */
	protected $topOfList = 1;

	/**
	 * Check if the current element is atthe top of the list
	 * @return boolean
	 */
	public function isFirst()
	{
		return $this->getAttribute($this->positionColumn) === $this->topOfList;
	}

	/**
	 * Check if the current element is at the end of the list
	 * @return boolean
	 */
	public function isLast()
	{
		if ($postion = $this->getAttribute($this->positionColumn)) {
			if (!$this->where($this->positionColumn, '>', $postion)) {
				return true;
			}
		}
	}
}
