<?php

namespace StructuredNavigation\Libs\MediaWiki;

use SearchEngine;
use Title;

/**
 * A namespace-agnostic searcher by default that allows retrieving titles
 * in a specific namespace. Intended for use in an instance of a \SpecialPage.
 *
 * @license MIT
 * @author Sam Nguyen < sam.t.nguyenn@gmail.com >
 */
final class NamespacedTitleSearcher {
	private SearchEngine $searchEngine;

	public function __construct( SearchEngine $searchEngine ) {
		$this->searchEngine = $searchEngine;
	}

	public function getTitlesInNamespace(
		string $search, int $resultLimit, int $titlesToSkip, int $namespace ) : array {
		$title = Title::newFromText( $search, $namespace );
		if ( $title && $title->getNamespace() !== $namespace ) {
			$title = Title::makeTitleSafe( $namespace, $search );
		}

		if ( !$title ) {
			return [];
		}

		$this->searchEngine->setLimitOffset( $resultLimit, $titlesToSkip );
		$this->searchEngine->setNamespaces( [ $namespace ] );
		$result = $this->searchEngine->defaultPrefixSearch( $search );

		return array_map( static function ( Title $t ) {
			// Remove namespace in search suggestion
			return $t->getText();
		}, $result );
	}
}
