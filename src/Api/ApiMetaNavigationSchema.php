<?php

namespace StructuredNavigation\Api;

use ApiQuery;
use ApiQueryBase;
use FormatJson;
use StructuredNavigation\Json\SchemaContent;

/**
 * This API module allows querying for the JSON schema used by
 * this extension to validate against the JSON structure of navigations.
 *
 * @license MIT
 */
final class ApiMetaNavigationSchema extends ApiQueryBase {

	/** @var SchemaContent */
	private $schemaContent;

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @param SchemaContent $schemaContent
	 */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		SchemaContent $schemaContent
	) {
		parent::__construct( $apiQuery, $moduleName );
		$this->schemaContent = $schemaContent;
	}

	/** @inheritDoc */
	public function execute() {
		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			FormatJson::decode( $this->schemaContent->getSchemaContent() )
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
