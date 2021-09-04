<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContentHandler;

/**
 * Content handler for a structured navigation.
 *
 * @license MIT
 */
final class NavigationContentHandler extends JsonContentHandler {
	public function __construct( string $modelId = CONTENT_MODEL_NAVIGATION ) {
		parent::__construct( $modelId );
	}

	/** @inheritDoc */
	protected function getContentClass(): string {
		return NavigationContent::class;
	}

	/** @inheritDoc */
	public function makeEmptyContent(): NavigationContent {
		return new NavigationContent(
			FormatJson::encode( $this->getPlaceholderContent(), "\t" )
		);
	}

	private function getPlaceholderContent(): array {
		return [
			'config' => [
				'title' => [
					'label' => ''
				]
			],
			'groups' => []
		];
	}
}
