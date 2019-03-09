<?php

namespace StructuredNavigation\Api;

use ApiQuery;
use ApiQueryBase;
use FormatJson;
use StructuredNavigation\Json\SchemaContent;

/**
 * @license MIT
 */
class ApiMetaNavigationSchema extends ApiQueryBase {

	/** @var SchemaContent */
	private $schemaContent;

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @param SchemaContent $schemaContent
	 */
	public function __construct( ApiQuery $apiQuery, $moduleName, SchemaContent $schemaContent ) {
		parent::__construct( $apiQuery, $moduleName );

		$this->schemaContent = $schemaContent;
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			FormatJson::decode( $this->schemaContent->getSchemaContent() )
		);
	}

}