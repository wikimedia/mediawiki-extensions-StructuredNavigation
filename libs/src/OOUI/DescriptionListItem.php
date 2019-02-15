<?php

namespace StructuredNavigation\Libs\OOUI;

use OOUI\HTMLSnippet;
use OOUI\Tag;

/**
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class DescriptionListItem {

	/** @var string HTML element representing a description term */
	private const ELEMENT_TERM = 'dt';

	/** @var string HTML element representing a description detail */
	private const ELEMENT_DETAIL = 'dd';

	/** @var string HTML element representing a content container */
	private const ELEMENT_CONTAINER = 'div';

	/**
	 * @param array $config
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
