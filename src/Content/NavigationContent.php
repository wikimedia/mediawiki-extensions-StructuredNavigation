<?php

namespace StructuredNavigation\Content;

use JsonContent;

/**
 * @license MIT
 */
final class NavigationContent extends JsonContent {

	/**
	 * @param string $text
	 */
	public function __construct( string $text ) {
		parent::__construct( $text, CONTENT_MODEL_NAVIGATION );
	}

}
