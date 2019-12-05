<?php
declare(strict_types=1);

class DocumentGrabber implements IGrabber
{

	/** @var \DOMDocument  */
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
		$firstResult = $this->getProductTile($productId);
		$gaData = $this->parseGaData($firstResult);

		if (array_key_exists('price', $gaData)) {
			return (float) $gaData['price'];
		}

		throw new ProductNotFoundException(
			sprintf('Price for product %s not found.', $productId),
			$productId
		);
	}

	/**
	 * @param string $productId
	 * @return float
	 */
	public function getName(string $productId): string
	{
		$firstResult = $this->getProductTile($productId);
		$gaData = $this->parseGaData($firstResult);

		if (array_key_exists('name', $gaData)) {
			return $gaData['name'];
		}

		return '';  // this is only additional info
	}

	/**
	 * @param string $productId
	 * @return int|null
	 */
	public function getRating(string $productId): ?int
	{
		$domxpath = new DOMXPath($this->document);
		$filtered = $domxpath->query("//div[@class='new-tile'][1]//span[@class='rating']");

		if ($filtered->length === 0) {
			// rating not found..
			return null;
		}

		$title = $filtered->item(0)->attributes->getNamedItem("title")->nodeValue;

		$matches = [];
		preg_match('/(\d+) %/', $title, $matches);

		if (count($matches) === 2) {
			return (int) $matches[1];
		}

		return null;
	}

	private function getProductTile(string $productId): DOMElement
	{
		$domxpath = new DOMXPath($this->document);
		$filtered = $domxpath->query("//div[@class='new-tile']");

		if ($filtered->length === 0) {
			throw new ProductNotFoundException(
				sprintf('Product %s not found on result page.', $productId),
				$productId
			);
		}

		return $filtered->item(0);
	}

	private function parseGaData(DOMElement $element): array
	{
		$gaDataEncoded = $element->attributes->getNamedItem("data-ga-impression")->nodeValue;

		return json_decode($gaDataEncoded, TRUE);
	}

}