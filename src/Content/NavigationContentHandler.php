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

	/**
	 * @param string $modelId
	 */
	public function __construct( string $modelId = CONTENT_MODEL_NAVIGATION ) {
		parent::__construct( $modelId );
	}

	/**
	 * @return string
	 */
	protected function getContentClass() : string {
		return NavigationContent::class;
	}

	/**
	 * @return NavigationContent
	 */
	public function makeEmptyContent() : NavigationContent {
		return new NavigationContent(
			FormatJson::encode( $this->getPlaceholderContent(), "\t" )
		);
	}

	/**
	 * @return array
	 */
	private function getPlaceholderContent() : array {
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
