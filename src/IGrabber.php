<?php
declare(strict_types=1);

namespace HPT;

interface IGrabber
{

	public function getPrice(string $productId): float;

	public function getName(string $productId): ?string;

	public function getRating(string $productId): ?int;

	public function setDocument(string $document): void;

}
