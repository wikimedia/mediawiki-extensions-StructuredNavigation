<?php

namespace StructuredNavigation\Libs\OOUI\Layout;

use OOUI\HtmlSnippet;
use OOUI\Layout;
use OOUI\GroupElement;
use OOUI\Tag;

/**
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class UnorderedListLayout extends Layout {

	use GroupElement;

	/**
	 * @param array $config
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );

		// do reset
		$this->removeClasses( [ 'oo-ui-layout' ] );

		// traits
		$this->initializeGroupElement(
			array_merge( $config, [ 'group' => $this ] )
		);

		// initialization
		if ( isset( $config['items'] ) ) {
			$allListItems = [];

			foreach( $config['items'] as $item ) {
				$listItem = $this->createListItem( $config );

				array_push(
					$allListItems,
					$listItem->appendContent( new HtmlSnippet( $item ) )
				);
			}

			$this->addItems( $allListItems );
		}
	}

	/**
	 * @return string
	 */
	public function getTagName() : string {
		return 'ul';
	}

	/**
	 * @param array $config
	 * @return Tag
	 */
	private function createListItem( array $config = [] ) : Tag {
		$listItem = new Tag( 'li' );

		if (
			isset( $config['item-attributes'] ) &&
			is_array( $config['item-attributes'] )
		) {
			$listItem->setAttributes( $config['item-attributes'] );
		}

		return $listItem;
	}
}