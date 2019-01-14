<?php

namespace StructuredNavigation;

use OOUI\Tag;
use TitleValue;

/**
 * Handles the setting of attributes for a structured navigation.
 *
 * @license GPL-2.0-or-later
 */
class AttributeQualifier {

	/** @var string */
	private const ATTR_DATA_NAME = 'data-structurednavigation-name';

	/**
	 * This will automatically assign the `data-structurednavigation-name`
	 * attribute by default. If the `id` attribute is set by the user, it'll
	 * also assign that as an attribute.
	 *
	 * @param Tag $renderedNavigation
	 * @param TitleValue $title
	 * @param array $attributes
	 * @return void
	 */
	public function setAttributes( Tag $renderedNavigation, TitleValue $title, array $attributes ) : void {
		$renderedNavigation->setAttributes( [
			self::ATTR_DATA_NAME => htmlspecialchars( $title->getText(), ENT_QUOTES )
		] );

		if ( isset( $attributes['id'] ) ) {
			$renderedNavigation->setAttributes( [
				'id' => htmlspecialchars( $attributes['id'], ENT_QUOTES )
			] );
		}
	}
}
