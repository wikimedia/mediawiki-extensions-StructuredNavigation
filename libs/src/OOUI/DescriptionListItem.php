<?php

namespace StructuredNavigation\Libs\OOUI;

use OOUI\HTMLSnippet;
use OOUI\Tag;

/**
 * Generates the HTML for an item in a description list. This will
 * contain a <dt> paired with a <dd>, and an option to have this inside
 * a <div> container (uses a container by default).
 *
 * @license MIT
 * @author Sam Nguyen < sam.t.nguyenn@gmail.com >
 */
class DescriptionListItem {

	/** HTML element representing a description term */
	private const ELEMENT_TERM = 'dt';

	/** HTML element representing a description detail */
	private const ELEMENT_DETAIL = 'dd';

	/** HTML element representing a content container */
	private const ELEMENT_CONTAINER = 'div';

	/**
	 * @param array $config
	 * 	bool $config['use-div-container'] Whether or not to contain this item in a <div>
	 * 	array $config['term-attributes'] HTML Attributes to apply to <dt>
	 * 	array $config['detail-attributes'] HTML Attributes to apply to <dd>
	 * 	array $config['container-attributes'] HTML Attributes to apply to <div> container
	 * @param string $termContent
	 * @param string $detailContent
	 * @return Tag|HtmlSnippet
	 */
	public function getItem(
		array $config = [],
		string $termContent,
		string $detailContent
	) {
		$htmlPair = new HtmlSnippet(
			$this->getTerm( $config )->appendContent( new HtmlSnippet( $termContent ) ) .
			$this->getDetail( $config )->appendContent( new HtmlSnippet( $detailContent ) )
		);

		if ( $config['use-div-container'] === true ) {
			return $this->getContainer( $htmlPair, $config );
		} else {
			return $htmlPair;
		}
	}

	/**
	 * @param string|Tag|HTMLSnippet ...$content
	 * @param array $config
	 * @return Tag
	 */
	private function getContainer( $content, array $config = [] ) : Tag {
		return $this->getElement( self::ELEMENT_CONTAINER, $config, 'container-attributes' )
			->appendContent( $content );
	}

	/**
	 * @param array $config
	 * @return Tag
	 */
	private function getTerm( array $config = [] ) : Tag {
		return $this->getElement( self::ELEMENT_TERM, $config, 'term-attributes' );
	}

	/**
	 * @param array $config
	 * @return Tag
	 */
	private function getDetail( array $config = [] ) : Tag {
		return $this->getElement( self::ELEMENT_DETAIL, $config, 'detail-attributes' );
	}

	/**
	 * @param string $elementName
	 * @param array $config
	 * @param string $elementAttributesKey
	 * @return Tag
	 */
	private function getElement( string $elementName, array $config, string $elementAttributesKey ) : Tag {
		$element = new Tag( $elementName );

		if (
			isset( $config[$elementAttributesKey] ) &&
			is_array( $config[$elementAttributesKey] )
		) {
			$element->setAttributes( $config[$elementAttributesKey] );
		}

		return $element;
	}
}
