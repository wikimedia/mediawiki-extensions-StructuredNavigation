<?php

namespace StructuredNavigation\Json;

use FormatJson;
use StructuredNavigation\Title\NavigationTitleValue;
use Title;
use WikiPage;

/**
 * This factory allows creating a JsonEntity object from a given source.
 *
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
	 * @param array $source
	 * @return JsonEntity
	 */
	public function newFromSource( array $source ) : JsonEntity {
		return new JsonEntity( $source );
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
			FormatJson::decode(
				WikiPage::factory( $title )->getContent()->getNativeData(), true
			)
		);
	}

}
