<?php

namespace MediaWiki\Extension\StructuredNavigation\Api\Rest;

use MediaWiki\Extension\StructuredNavigation\DocumentationContent;
use MediaWiki\Rest\SimpleHandler;

/**
 * @license MIT
 */
class NavigationExamplesHandler extends SimpleHandler {
	use NavigationRESTEnabledTrait;

	private DocumentationContent $documentationContent;

	public function __construct( DocumentationContent $documentationContent ) {
		$this->documentationContent = $documentationContent;
	}

	public function run() {
		$this->showErrorIfDisabled();

		return $this->documentationContent->getExamples();
	}

	/** @inheritDoc */
	public function needsWriteAccess(): bool {
		return false;
	}
}
