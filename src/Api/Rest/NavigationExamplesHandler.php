<?php

namespace StructuredNavigation\Api\Rest;

use MediaWiki\Rest\SimpleHandler;
use StructuredNavigation\DocumentationContent;

/**
 * @license MIT
 */
class NavigationExamplesHandler extends SimpleHandler {
	private DocumentationContent $documentationContent;

	public function __construct( DocumentationContent $documentationContent ) {
		$this->documentationContent = $documentationContent;
	}

	public function run() {
		return $this->documentationContent->getExamples();
	}

	/** @inheritDoc */
	public function needsWriteAccess() : bool {
		return false;
	}
}
