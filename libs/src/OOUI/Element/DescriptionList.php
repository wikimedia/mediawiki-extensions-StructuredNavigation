<?php

namespace StructuredNavigation\Libs\OOUI\Element;

use OOUI\Element;
use OOUI\HtmlSnippet;
use OOUI\GroupElement;
use OOUI\Tag;

/**
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class DescriptionList extends Element {

	use GroupElement;

	/**
	 * @param array $config
	 */
	public function __construct( array $config = [] ) {

		// config initialization
		$config = array_merge( [ 'use-div-container' => true ], $config );

		// parent constructor
		parent::__construct( $config );

		// traits
		$this->initializeGroupElement(
			array_merge( $config, [ 'group' => $this ] )
		);

		// initialization
		if ( isset( $config['items'] ) ) {
			$allItems = [];

			foreach ( $config['items'] as $item ) {
				array_push(
					$allItems,
					$this->createPairedTermDescription(
						$config,
						$item['term'],
						$item['detail']
					)
				);
			}

			$this->addItems( $allItems );
		} 
	}

	/**
	 * @return string
	 */
	public function getTagName() : string {
		return 'dl';
	}

	/**
	 * @param array $config
	 * @param string $termContent
	 * @param string $detailContent
	 * @return Tag|HtmlSnippet
	 */
	private function createPairedTermDescription(
		array $config = [],
		string $termContent,
		string $detailContent
	) {
		$term = new Tag( 'dt' );
		$detail = new Tag( 'dd' );

		if (
			isset( $config['term-attributes'] ) &&
			is_array( $config['term-attributes'] )
		) {
			$term->setAttributes( $config['term-attributes'] );
		}

		if (
			isset( $config['detail-attributes'] ) &&
			is_array( $config['detail-attributes'] )
		) {
			$detail->setAttributes( $config['detail-attributes'] );
		}

		$htmlPair = new HtmlSnippet(
			$term->appendContent( new HtmlSnippet( $termContent ) ) .
			$detail->appendContent( new HtmlSnippet( $detailContent ) )
		);

		if ( $config['use-div-container'] === true ) {
			$divContainer = new Tag( 'div' );
			if (
				isset( $config['container-attributes'] ) &&
				is_array( $config['container-attributes'] )
			) {
				$divContainer->setAttributes( $config['container-attributes'] );
			}

			return $divContainer->appendContent( $htmlPair );

		} else {
			return $htmlPair;
		}
	}
}