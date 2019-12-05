<?php
declare(strict_types=1);

class Dispatcher
{

	/**
	 * @var IFetcher
	 */
	private $fetcher;
	/**
	 * @var IGrabber
	 */
	private $grabber;
	/**
	 * @var IOutput
	 */
	private $output;

	/**
	 * @param IFetcher $fetcher
	 * @param IGrabber $grabber
	 * @param IOutput $output
	 */
	public function __construct(IFetcher $fetcher, IGrabber $grabber, IOutput $output)
	{
		$this->fetcher = $fetcher;
		$this->grabber = $grabber;
		$this->output = $output;
	}

	/**
	 * @return string JSON
	 */
	public function run(): string
	{
		$productCodes = file('vstup.txt');

		foreach($productCodes as $productCode) {
			try {
				$productCode = trim($productCode);
				$document = $this->fetcher->fetch($productCode);

				$this->grabber->setDocument($document);

				$this->output->addResult([$productCode => [
						'price' => $this->grabber->getPrice($productCode),
						'name' => $this->grabber->getName($productCode),
						'rating' => $this->grabber->getRating($productCode),
					]
				]);
			} catch (\ProductNotFoundException $e) {
				// we have a problem, log it somewhere...
				$this->output->addResult([$e->getProductCode() => null]);
			}

		}

		return $this->output->getJson();
	}

}
