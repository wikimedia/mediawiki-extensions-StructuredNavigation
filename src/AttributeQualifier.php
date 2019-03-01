<?php

namespace StructuredNavigation;

use OOUI\Tag;
use TitleValue;

/**
 * Handles the setting of attributes for a structured navigation.
 *
 * @license MIT
 */
final class AttributeQualifier {

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
			self::ATTR_DATA_NAME => $this->escapeAttributeContent( $title->getText() )
		] );

		if ( isset( $attributes['id'] ) ) {
			$renderedNavigation->setAttributes( [
				'id' => $this->escapeAttributeContent( $attributes['id'] )
			] );
		}
	}

	/**
	 * @param string $attribute
	 * @return string
	 */
	private function escapeAttributeContent( string $attribute ) : string {
		return htmlspecialchars( $attribute, ENT_QUOTES );
	}
}
