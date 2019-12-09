<?php
declare(strict_types=1);

namespace HPT;

class ProductData implements \JsonSerializable
{

	/** @var float */
	private $price;

	/** @var string|null */
	private $name;

	/** @var int|null */
	private $rating;

	public function __construct(float $price, ?string $name = null, ?int $rating = null)
	{
		$this->price = $price;
		$this->name = $name;
		$this->rating = $rating;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function getRating(): ?int
	{
		return $this->rating;
	}

	public function jsonSerialize(): array
	{
		return [
			'price' => $this->getPrice(),
			'name' => $this->getName(),
			'rating' => $this->getRating(),
		];
	}

}
