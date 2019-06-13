<?php

namespace StructuredNavigation\Libs\MediaWiki;

use SearchEngine;
use Title;

/**
 * A namespace-agnostic searcher by default that allows retrieving titles
 * in a specific namespace. Intended for use in an instance of a \SpecialPage.
 *
 * @license MIT
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
final class NamespacedTitleSearcher {

	/** @var SearchEngine */
	private $searchEngine;

	/**
	 * @param SearchEngine $searchEngine
	 */
	public function __construct( SearchEngine $searchEngine ) {
		$this->searchEngine = $searchEngine;
	}

	/**
	 * @param string $search Prefix to search for
	 * @param int $limit Maximum number of results to return (usually 10)
	 * @param int $offset Number of results to skip (usually 0)
	 * @param int $namespace Unique ID of namespace
	 * @return array
	 */
	public function getTitlesInNamespace( string $search, int $limit, int $offset, int $namespace ) : array {
		$title = Title::newFromText( $search, $namespace );
		if ( $title && $title->getNamespace() !== $namespace ) {
			$title = Title::makeTitleSafe( $namespace, $search );
		}

		if ( !$title ) {
			return [];
		}

		$this->searchEngine->setLimitOffset( $limit, $offset );
		$this->searchEngine->setNamespaces( [ $namespace ] );
		$result = $this->searchEngine->defaultPrefixSearch( $search );

		return array_map( function ( Title $t ) {
			// Remove namespace in search suggestion
			return $t->getText();
		}, $result );
	}

}
