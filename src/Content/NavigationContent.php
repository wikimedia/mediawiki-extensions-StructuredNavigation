<?php

namespace MediaWiki\Extension\StructuredNavigation\Content;

use MediaWiki\Content\JsonContent;
use MediaWiki\Extension\StructuredNavigation\Services\Services;

/**
 * Content object for representing a structured navigation.
 *
 * @license MIT
 */
final class NavigationContent extends JsonContent {
	public function __construct( string $text ) {
		parent::__construct( $text, CONTENT_MODEL_NAVIGATION );
	}

	/** @inheritDoc */
	public function isValid() {
		return $this->isValidStatus()->isGood();
	}

	public function isValidStatus() {
		$validator = Services::getInstance()->getNavigationValidator();
		return $validator->validate(
			$this->getData()->getValue()
		);
	}
}
