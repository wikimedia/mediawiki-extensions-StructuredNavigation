<?php

namespace StructuredNavigation;

use FormatJson;
use StructuredNavigation\Title\NavigationTitleValue;
use Title;
use WikiPage;

/**
 * @license MIT
 */
class NavigationFactory {
	private NavigationTitleValue $navigationTitleValue;

	public function __construct( NavigationTitleValue $navigationTitleValue ) {
		$this->navigationTitleValue = $navigationTitleValue;
	}

	public function newFromSource( array $source ) : Navigation {
		return new Navigation( $source );
	}

	/**
	 * Attempts to make a new Navigation object from a given title.
	 * Returns false otherwise if the title doesn't exist.
	 *
	 * @param string $passedTitle
	 * @return Navigation|false
	 */
	public function newFromTitle( string $passedTitle ) {
		$title = Title::newFromTitleValue( $this->navigationTitleValue->getTitleValue( $passedTitle ) );

		if ( !$title->exists() ) {
			return false;
		}

		return new Navigation(
			FormatJson::decode(
				WikiPage::factory( $title )->getContent()->getNativeData(), true
			)
		);
	}
}
