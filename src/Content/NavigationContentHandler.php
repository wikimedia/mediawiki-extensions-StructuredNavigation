<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContentHandler;

/**
 * @license GPL-2.0-or-later
 */
final class NavigationContentHandler extends JsonContentHandler {

	/**
	 * @param string $modelId
	 */
	public function __construct( string $modelId = CONTENT_MODEL_NAVIGATION ) {
		parent::__construct( $modelId, [ CONTENT_FORMAT_JSON ] );
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
			FormatJson::encode( [ 'name' => '', 'groups' => '' ], "\t" )
		);
	}

}
