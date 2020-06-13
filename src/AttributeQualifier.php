<?php

namespace StructuredNavigation;

use OOUI\Tag;

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
	 */
	public function setAttributes( Tag $navigation, array $attributes ) : void {
		$navigation->setAttributes( [
			self::ATTR_DATA_NAME => $this->escapeAttributeContent( $attributes['title'] )
		] );

		if ( isset( $attributes['id'] ) ) {
			$navigation->setAttributes( [
				'id' => $this->escapeAttributeContent( $attributes['id'] )
			] );
		}
	}

	private function escapeAttributeContent( string $attribute ) : string {
		return htmlspecialchars( $attribute, ENT_QUOTES );
	}
}
