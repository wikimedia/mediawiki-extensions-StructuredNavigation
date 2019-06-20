<?php

namespace StructuredNavigation\Api;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use FormatJson;

/**
 * @license MIT
 */
class ApiMetaNavigationExamples extends ApiQueryBase {

	/** @inheritDoc */
	public function __construct( ApiQuery $apiQuery, string $moduleName ) {
		parent::__construct( $apiQuery, $moduleName );
	}

	/** @inheritDoc */
	public function execute() {
		$this->getResult()->addValue( 'query', $this->getModuleName(), $this->getNavExamples() );
	}

	private function getNavExamples() {
		$extensionDirectory = $this->getConfig()->get( 'ExtensionDirectory' );

		$prefix = "{$extensionDirectory}/StructuredNavigation/docs/examples/";
		$files = "{$prefix}*.json";
		$globFiles = glob( $files );
		$allContent = [];

		foreach( $globFiles as $file ) {
			$content = FormatJson::decode( file_get_contents( $file ) );
			$allContent[str_replace($prefix,'', $file)] = $content;
		}

		return $allContent;
	}

	/** @inheritDoc */
	protected function getExamplesMessages() {
		return [
			"action=query&meta={$this->getModuleName()}"
				=> 'apihelp-query+structurednavigationexamples-example',
		];
	}

}
