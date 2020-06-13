<?php

namespace StructuredNavigation\Title;

use TitleParser;
use TitleValue;

/**
 * @license MIT
 */
class NavigationTitleValue {
	private TitleParser $titleParser;

	public function __construct( TitleParser $titleParser ) {
		$this->titleParser = $titleParser;
	}

	public function getTitleValue( string $title ) : TitleValue {
		return $this->titleParser->parseTitle( $title, NS_NAVIGATION );
	}
}
