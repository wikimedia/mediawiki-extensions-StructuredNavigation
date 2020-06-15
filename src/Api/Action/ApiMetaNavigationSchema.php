<?php

namespace StructuredNavigation\Api\Action;

use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\DocumentationContent;

/**
 * This API module allows querying for the JSON schema used by
 * this extension to validate against the JSON structure of navigations.
 *
 * @license MIT
 */
final class ApiMetaNavigationSchema extends ApiQueryBase {
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
			$this->documentationContent->getDecodedSchemaContent()
		);
	}

	/** @inheritDoc */
	protected function getExamplesMessages() {
		return [
			"action=query&meta={$this->getModuleName()}"
				=> 'apihelp-query+structurednavigationschema-example',
		];
	}
}
