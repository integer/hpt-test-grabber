<?php
declare(strict_types=1);

namespace HPT;

class ResultOutput implements IOutput
{

	/** @var array<string, \HPT\ProductData|null> */
	private $results = [];

	public function addResult(string $productCode, ?ProductData $productData): void
	{
		$this->results[$productCode] = $productData;
	}

	public function getJson(): string
	{
		return json_encode($this->results);
	}

}
