<?php
declare(strict_types=1);

class DocumentGrabber implements IGrabber
{

	private $document = null;

	// New instance for every document would be better, but dispatcher requires IGrabber in __construct.
	public function setDocument(string $document): void
	{
		$d = new DOMDocument();

		$document = @$d->loadHTML($document);
		if ($document === FALSE) {
			throw new \RuntimeException('Document load failed.');
		}

		$this->document = $d;
	}

	/**
	 * @param string $productId
	 * @return float
	 * @throws \ProductNotFoundException
	 */
	public function getPrice(string $productId): float
	{
		$domxpath = new DOMXPath($this->document);
		$filtered = $domxpath->query("//div[@class='new-tile']");

		if ($filtered->length === 0) {
			throw new ProductNotFoundException(
				sprintf('Product %s not found on result page.', $productId),
				$productId
			);
		}

		$firstResult = $filtered->item(0);

		$gaDataEncoded = $firstResult->attributes->getNamedItem("data-ga-impression")->nodeValue;

		$gaData = json_decode($gaDataEncoded, TRUE);

		if (array_key_exists('price', $gaData)) {
			return (float) $gaData['price'];
		}

		throw new ProductNotFoundException(
			sprintf('Price for product %s not found.', $productId),
			$productId
		);
	}

}