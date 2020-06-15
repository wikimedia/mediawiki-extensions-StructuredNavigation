<?php

namespace StructuredNavigation\Api\Action;

use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\DocumentationContent;

/**
 * @license MIT
 */
class ApiMetaNavigationExamples extends ApiQueryBase {
	private DocumentationContent $documentationContent;

	/** @inheritDoc */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		DocumentationContent $documentationContent
	) {
		parent::__construct( $apiQuery, $moduleName );
		$this->documentationContent = $documentationContent;
	}

	/** @inheritDoc */
	public function execute() {
		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			$this->documentationContent->getExamples()
		);
	}

	/** @inheritDoc */
	protected function getExamplesMessages() {
		return [
			"action=query&meta={$this->getModuleName()}"
				=> 'apihelp-query+structurednavigationexamples-example',
		];
	}
}
