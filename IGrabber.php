<?php
declare(strict_types=1);

interface IGrabber
{

	/**
	 * @param string $productId
	 * @return float
	 */
	public function getPrice(string $productId): float;

	/**
	 * @param string $document
	 */
	public function setDocument(string $document): void;

}
