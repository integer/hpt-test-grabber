<?php
declare(strict_types=1);

namespace HPT;

interface IFetcher
{

	/**
	 * @throws \HPT\ProductNotFoundException
	 */
	public function fetch(string $productCode): string;

}
