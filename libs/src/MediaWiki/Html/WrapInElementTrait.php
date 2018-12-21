<?php

namespace StructuredNavigation\Libs\MediaWiki\Html;

use Html;

/**
 * @license GPL-2.0-or-later
 */
trait WrapInElementTrait {

	/**
	 * @param string $element
	 * @param string $content
	 * @param array|null $classes
	 * @return string
	 */
	public function doWrapInElement( string $element, string $content, array $classes = null ) : string {
		$attributes = [];
		if ( !is_null( $classes ) ) {
			$attributes['class'] = $this->getCssClasses( $classes );
		}

		return Html::openElement( $element, $attributes ) .
			$content .
			Html::closeElement( $element );
	}

	/**
	 * @param array|null $classes
	 * @return string|null
	 */
	private function getCssClasses( $classes ) {
		return implode( ' ', $classes );
	}
}
