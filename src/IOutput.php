<?php
declare(strict_types=1);

namespace HPT;

interface IOutput
{

	public function getJson(): string;

	public function addResult(string $productCode, ?ProductData $productData): void;

}
