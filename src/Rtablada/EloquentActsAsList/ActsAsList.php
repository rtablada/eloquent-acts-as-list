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
		if ($position = $this->getAttribute($this->positionColumn)) {
			if (!$this->where($this->positionColumn, '>', $position)->first()) {
				return true;
			}
		}
	}

	/**
	 * Decrements the position value
	 *
	 * @param  integer $amount
	 *
	 * @return void
	 */
	public function decrementPosition($amount = 1)
	{
		$this->decrement($this->positionColumn, $amount);
		$this->save();
	}

	/**
	 * Increments the position value
	 *
	 * @param  integer $amount
	 *
	 * @return void
	 */
	public function incrementPosition($amount = 1)
	{
		$this->increment($this->positionColumn, $amount);
	}


	/**
	 * Gets the next item in the list
	 * @return Eloquent
	 */
	public function getNextItem()
	{
		$position = $this->getAttribute($this->positionColumn);

		return $this->where($this->positionColumn, $position + 1)->first();
	}

	/**
	 * Gets the previous item in the list
	 * @return Eloquent
	 */
	public function getPreviousItem()
	{
		$position = $this->getAttribute($this->positionColumn);

		return $this->where($this->positionColumn, $position - 1)->first();
	}

	/**
	 * Swap position with the next item
	 *
	 * @return void
	 */
	public function moveLower()
	{
		if (!$this->isLast()) {
			$this->getNextItem()->decrementPosition();
			$this->incrementPosition();
		}
	}

	/**
	 * Swap position with the previous item
	 *
	 * @return void
	 */
	public function moveHigher()
	{
		if (!$this->isFirst()) {
			$this->getPreviousItem()->incrementPosition();
			$this->decrementPosition();
		}
	}
}
