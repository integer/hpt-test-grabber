<?php
declare(strict_types=1);

interface IFetcher
{

	/**
	 * @param string $productCode
	 * @return string
	 * @throws \ProductNotFoundException
	 */
	public function fetch(string $productCode): string;

}
