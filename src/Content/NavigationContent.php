<?php

namespace StructuredNavigation\Content;

use JsonContent;

/**
 * @license GPL-2.0-or-later
 */
final class NavigationContent extends JsonContent {

	/**
	 * @param string $modelId
	 */
	public function __construct( string $modelId = CONTENT_MODEL_NAVIGATION ) {
		parent::__construct( $modelId );
	}
}
