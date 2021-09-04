<?php

namespace StructuredNavigation\Libs\OOUI\Element;

use OOUI\Element;
use OOUI\GroupElement;
use OOUI\HtmlSnippet;
use OOUI\Tag;

/**
 * Generates HTML for making unordered lists.
 *
 * @license MIT
 * @author Sam Nguyen < sam.t.nguyenn@gmail.com >
 */
class UnorderedList extends Element {
	use GroupElement;

	private const ELEMENT_UNORDERED_LIST = 'ul';
	private const ELEMENT_UNORDERED_LIST_ITEM = 'li';

	/**
	 * @param array $config
	 * 	array $config['item-attributes'] Attributes to apply to the <li> instances
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );

		$this->initializeGroupElement(
			array_merge( $config, [ 'group' => $this ] )
		);

		if ( isset( $config['items'] ) ) {
			$allListItems = [];

			foreach ( $config['items'] as $item ) {
				$listItem = $this->createListItem( $config );
				$allListItems[] = $listItem->appendContent( new HtmlSnippet( $item ) );
			}

			$this->addItems( $allListItems );
		}
	}

	/**
	 * @return string
	 */
	public function getTagName(): string {
		return self::ELEMENT_UNORDERED_LIST;
	}

	/**
	 * @param array $config
	 * @return Tag
	 */
	private function createListItem( array $config = [] ): Tag {
		$listItem = new Tag( self::ELEMENT_UNORDERED_LIST_ITEM );

		if (
			isset( $config['item-attributes'] ) &&
			is_array( $config['item-attributes'] )
		) {
			$listItem->setAttributes( $config['item-attributes'] );
		}

		return $listItem;
	}
}
