<?php

namespace StructuredNavigation\Json;

use WikiPage;
use StructuredNavigation\Title\NavigationTitleValue;
use Title;

/**
 * @license MIT
 */
class JsonEntityFactory {

	/** @var NavigationTitleValue */
	private $navigationTitleValue;

	/**
	 * @param NavigationTitleValue $navigationTitleValue
	 */
	public function __construct( NavigationTitleValue $navigationTitleValue ) {
		$this->navigationTitleValue = $navigationTitleValue;
	}

	/**
	 * Attempts to make a new JsonEntity from a given title.
	 * Returns false otherwise if the title doesn't exist.
	 *
	 * @param string $passedTitle
	 * @return JsonEntity|false
	 */
	public function newFromTitle( string $passedTitle ) {
		$title = Title::newFromTitleValue( $this->navigationTitleValue->getTitleValue( $passedTitle ) );

		if ( !$title->exists() ) {
			return false;
		}

		return new JsonEntity(
			WikiPage::factory( $title )->getContent()->getJsonData()
		);
	}

}
