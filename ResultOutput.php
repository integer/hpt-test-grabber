<?php
declare(strict_types=1);

class ResultOutput implements IOutput
{

	/** @var array */
	private $results = [];

	public function addResult($data)
	{
		$this->results = $this->results + $data;
	}

	/**
	 * @return string
	 */
	public function getJson(): string
	{
		return json_encode($this->results);
	}

}
