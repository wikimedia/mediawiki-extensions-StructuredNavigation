<?php

namespace MediaWiki\Extension\StructuredNavigation\Api\Rest;

use MediaWiki\Extension\StructuredNavigation\DocumentationContent;
use MediaWiki\Rest\SimpleHandler;

/**
 * @license MIT
 */
class NavigationSchemaHandler extends SimpleHandler {
	use NavigationRESTEnabledTrait;

	private DocumentationContent $documentationContent;

	public function __construct( DocumentationContent $documentationContent ) {
		$this->documentationContent = $documentationContent;
	}

	public function run() {
		$this->showErrorIfDisabled();

		return $this->documentationContent->getDecodedSchemaContent();
	}

	/** @inheritDoc */
	public function needsWriteAccess(): bool {
		return false;
	}
}
