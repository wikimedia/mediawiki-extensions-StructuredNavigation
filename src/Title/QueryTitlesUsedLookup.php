<?php

namespace StructuredNavigation\Title;

use StructuredNavigation\Json\JsonEntity;
use StructuredNavigation\Json\JsonEntityFactory;

/**
 * @license MIT
 */
final class QueryTitlesUsedLookup {

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/**
	 * @param JsonEntityFactory $jsonEntityFactory
	 */
	public function __construct( JsonEntityFactory $jsonEntityFactory ) {
		$this->jsonEntityFactory = $jsonEntityFactory;
	}

	/**
	 * For a given title in the Navigation namespace, retrieve all
	 * titles that are being used for the specific navigation as
	 * strings in an array.
	 *
	 * @param string $navigationTitle
	 * @return string[]
	 */
	public function getTitlesUsed( string $navigationTitle ) : array {
		$jsonEntity = $this->getJsonEntity( $navigationTitle );
		$titlesUsed = [];
		$allGroups = $jsonEntity->getGroups();

		foreach ( $allGroups as $group ) {
			foreach ( $jsonEntity->getGroupContent( $group ) as $contentItem ) {
				if ( is_array( $contentItem ) ) {
					$titlesUsed[] = $contentItem[0];
				} else {
					$titlesUsed[] = $contentItem;
				}
			}
		}

		return array_unique( $titlesUsed );
	}

	/**
	 * @param string $title
	 * @return JsonEntity
	 */
	private function getJsonEntity( string $title ) : JsonEntity {
		return $this->jsonEntityFactory->newFromTitle( $title );
	}

}
