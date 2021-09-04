<?php

namespace StructuredNavigation\Api\Rest;

use MediaWiki\Rest\SimpleHandler;
use StructuredNavigation\DocumentationContent;

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
