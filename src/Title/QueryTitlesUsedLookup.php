<?php

namespace StructuredNavigation\Title;

use StructuredNavigation\Navigation;
use StructuredNavigation\NavigationFactory;

/**
 * This service retrieves all titles that are being used
 * for a given navigation by title.
 *
 * @license MIT
 */
final class QueryTitlesUsedLookup {
	private NavigationFactory $navigationFactory;

	public function __construct( NavigationFactory $navigationFactory ) {
		$this->navigationFactory = $navigationFactory;
	}

	public function getTitlesUsed( string $navigationTitle ) : array {
		$jsonEntity = $this->getNavigation( $navigationTitle );
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

	private function getNavigation( string $title ) : Navigation {
		return $this->navigationFactory->newFromTitle( $title );
	}
}
