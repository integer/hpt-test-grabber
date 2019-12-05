<?php
declare(strict_types=1);

class DocumentFetcher implements IFetcher
{

	/**
	 * @throws \ProductNotFoundException
	 */
	public function fetch(string $productCode): string
	{
		$documentContent = file_get_contents($this->constructURL($productCode));
		if ($documentContent === FALSE) {
			throw new \ProductNotFoundException(
				sprintf('Document fetch for document "%s" failed.', $productCode),
				$productCode
			);
		}

		return $documentContent;
	}

	private function constructURL($productCode): string
	{
		return sprintf('https://www.czc.cz/%s/hledat', $productCode);
	}

}
