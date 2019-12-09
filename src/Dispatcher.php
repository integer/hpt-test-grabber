<?php
declare(strict_types=1);

namespace HPT;

class Dispatcher
{

	/** @var IFetcher */
	private $fetcher;

	/** @var IGrabber */
	private $grabber;

	/** @var IOutput */
	private $output;

	public function __construct(IFetcher $fetcher, IGrabber $grabber, IOutput $output)
	{
		$this->fetcher = $fetcher;
		$this->grabber = $grabber;
		$this->output = $output;
	}

	public function run(string $inputFilename): string
	{
		$productCodes = @file($inputFilename);
		if ($productCodes === FALSE) {
			printf('File "%s" not found.', $inputFilename);
			exit(3);
		}

		foreach($productCodes as $productCode) {
			try {
				$productCode = trim($productCode);
				$document = $this->fetcher->fetch($productCode);

				$this->grabber->setDocument($document);

				$this->output->addResult(
					$productCode,
					new ProductData(
						$this->grabber->getPrice($productCode),
						$this->grabber->getName($productCode),
						$this->grabber->getRating($productCode)
					)
				);
			} catch (\HPT\ProductNotFoundException $e) {
				// we have a problem, log it somewhere...
				$this->output->addResult($e->getProductCode(),null);
			}

		}

		return $this->output->getJson();
	}

}
