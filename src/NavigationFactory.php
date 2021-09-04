<?php

namespace StructuredNavigation;

use FormatJson;
use MediaWiki\Revision\RevisionLookup;
use MediaWiki\Revision\SlotRecord;
use TitleParser;

/**
 * @license MIT
 */
final class NavigationFactory {
	private RevisionLookup $revisionLookup;
	private TitleParser $titleParser;

	public function __construct( RevisionLookup $revisionLookup, TitleParser $titleParser ) {
		$this->revisionLookup = $revisionLookup;
		$this->titleParser = $titleParser;
	}

	public function newFromSource( array $source ): Navigation {
		$content = $source;
		$jsonGroups = $content['groups'];
		$objectGroups = [];
		foreach ( $jsonGroups as $jsonGroup ) {
			$links = [];
			foreach ( $jsonGroup['content'] as $stringOrArrayLink ) {
				if ( is_array( $stringOrArrayLink ) ) {
					$links[] = $this->parseNavigationLink( $stringOrArrayLink );

				} else {
					$links[] = $this->parseNavigationLink( $stringOrArrayLink );
				}
			}

			$objectGroups[] = new NavigationGroup(
				$jsonGroup['title']['label'],
				$links
			);
		}

		return new Navigation(
			$content,
			$content['config']['title']['label'],
			$objectGroups
		);
	}

	/**
	 * Attempts to make a new Navigation object from a given title.
	 * Returns false otherwise if the title doesn't exist.
	 *
	 * @param string $passedTitle
	 * @return Navigation|false
	 */
	public function newFromTitle( string $passedTitle ) {
		$title = $this->titleParser->parseTitle( $passedTitle, NS_NAVIGATION );
		$revisionFromTitle = $this->revisionLookup->getRevisionByTitle( $title );
		if ( $revisionFromTitle === null ) {
			return false;
		}

		return $this->newFromSource(
			FormatJson::decode(
				$revisionFromTitle
					->getContent( SlotRecord::MAIN )
					->getText(),
				true
			)
		);
	}

	private function parseNavigationLink( $stringOrArrayLink ): NavigationGroupLink {
		if ( is_array( $stringOrArrayLink ) ) {
			return new NavigationGroupLink(
				$this->titleParser->parseTitle( $stringOrArrayLink[0] ),
				$stringOrArrayLink[0],
				$stringOrArrayLink[1]
			);
		} else {
			return new NavigationGroupLink(
				$this->titleParser->parseTitle( $stringOrArrayLink ), $stringOrArrayLink );
		}
	}
}
