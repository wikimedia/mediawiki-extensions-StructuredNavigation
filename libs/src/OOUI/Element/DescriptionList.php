<?php

namespace StructuredNavigation\Libs\OOUI\Element;

use OOUI\Element;
use OOUI\GroupElement;
use StructuredNavigation\Libs\OOUI\DescriptionListItem;

/**
 * Generates HTML for making description lists.
 *
 * @license MIT
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class DescriptionList extends Element {

	use GroupElement;

	/** @var string HTML element representing a description list */
	private const ELEMENT_DESCRIPTION_LIST = 'dl';

	/**
	 * @param array $config
	 * 	bool $config['use-div-container'] Whether or not to contain ALL items in a <div>
	 * 	array $config['term-attributes'] HTML attributes to apply to ALL <dt> instances
	 * 	array $config['detail-attributes'] HTML Attributes to apply to ALL <dd> instances
	 * 	array $config['container-attributes'] HTML attributes to apply to ALL <div> container instances
	 */
	public function __construct( array $config = [] ) {
		$config = array_merge( [ 'use-div-container' => true ], $config );

		parent::__construct( $config );

		$this->initializeGroupElement(
			array_merge( $config, [ 'group' => $this ] )
		);

		if ( isset( $config['items'] ) ) {
			$allItems = [];

			$descriptionListItem = new DescriptionListItem();
			foreach ( $config['items'] as $item ) {
				array_push(
					$allItems,
					$descriptionListItem->getItem( $config, $item['term'], $item['detail'] )
				);
			}

			$this->addItems( $allItems );
		}
	}

	/**
	 * @return string
	 */
	public function getTagName() : string {
		return self::ELEMENT_DESCRIPTION_LIST;
	}

}
