<?php

namespace StructuredNavigation\Title;

use StructuredNavigation\Json\JsonEntity;
use StructuredNavigation\Json\JsonEntityFactory;

/**
 * This service retrieves all titles that are being used
 * for a given navigation by title.
 *
 * @license MIT
 */
final class QueryTitlesUsedLookup {
	private JsonEntityFactory $jsonEntityFactory;

	public function __construct( JsonEntityFactory $jsonEntityFactory ) {
		$this->jsonEntityFactory = $jsonEntityFactory;
	}

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

	private function getJsonEntity( string $title ) : JsonEntity {
		return $this->jsonEntityFactory->newFromTitle( $title );
	}
}
