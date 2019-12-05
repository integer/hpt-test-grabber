<?php
declare(strict_types=1);

class ProductNotFoundException extends \Exception
{

	/**
	 * @var string
	 */
	private $productCode;

	public function __construct(string $message = '', string $productCode, \Throwable $previous = null)
	{
		parent::__construct($message, 0, $previous);

		$this->productCode = $productCode;
	}

	/**
	 * @return string
	 */
	public function getProductCode(): string
	{
		return $this->productCode;
	}

}
