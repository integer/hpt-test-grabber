<?php
declare(strict_types=1);

namespace HPT;

class DocumentFetcher implements IFetcher
{

	/**
	 * @throws \HPT\ProductNotFoundException
	 */
	public function fetch(string $productCode): string
	{
		$documentContent = file_get_contents($this->constructURL($productCode));
		if ($documentContent === FALSE) {
			throw new \HPT\ProductNotFoundException(
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
