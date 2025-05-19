<?php

namespace MediaWiki\Extension\StructuredNavigation\Libs;

use MediaWiki\Title\Title;
use MediaWiki\Title\TitleFactory;
use SearchEngine;

/**
 * A namespace-agnostic searcher by default that allows retrieving titles
 * in a specific namespace. Intended for use in an instance of a SpecialPage.
 *
 * @license MIT
 */
final class NamespacedTitleSearcher {
	private SearchEngine $searchEngine;
	private TitleFactory $titleFactory;

	public function __construct(
		SearchEngine $searchEngine,
		TitleFactory $titleFactory
	) {
		$this->searchEngine = $searchEngine;
		$this->titleFactory = $titleFactory;
	}

	public function getTitlesInNamespace(
		string $search, int $resultLimit, int $titlesToSkip, int $namespace ): array {
		$title = $this->titleFactory->newFromText( $search, $namespace );
		if ( $title && $title->getNamespace() !== $namespace ) {
			$title = $this->titleFactory->makeTitleSafe( $namespace, $search );
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
