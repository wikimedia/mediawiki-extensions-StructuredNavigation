<?php

namespace MediaWiki\Extension\StructuredNavigation;

use MediaWiki\Extension\StructuredNavigation\Content\NavigationContent;
use MediaWiki\Json\FormatJson;
use MediaWiki\Revision\RevisionAccessException;
use MediaWiki\Revision\RevisionLookup;
use MediaWiki\Revision\SlotRecord;
use MediaWiki\Title\MalformedTitleException;
use MediaWiki\Title\TitleParser;

/**
 * @license MIT
 */
final class NavigationFactory {
	private RevisionLookup $revisionLookup;
	private TitleParser $titleParser;

	public function __construct(
		RevisionLookup $revisionLookup,
		TitleParser $titleParser
	) {
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
				$link = NavigationGroupLink::parseOrNull(
					$this->titleParser, $stringOrArrayLink );

				if ( $link !== null ) {
					$links[] = $link;
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
	 * Returns false otherwise if:
	 * - the title doesn't exist
	 * - the title text does not match a valid title representation
	 * - the content slot does not exist
	 *
	 * @todo Refactor to return Status so it's more informative
	 * @param string $passedTitle
	 * @return Navigation|false
	 */
	public function newFromTitle( string $passedTitle ) {
		try {
			$title = $this->titleParser->parseTitle( $passedTitle, NS_NAVIGATION );
			$revisionFromTitle = $this->revisionLookup->getRevisionByTitle( $title );
			if ( $revisionFromTitle === null ) {
				return false;
			}

			/** @var NavigationContent */
			$content = $revisionFromTitle->getContent( SlotRecord::MAIN );
			return $this->newFromSource(
				FormatJson::decode(
					$content->getText(),
					true
				)
			);
		} catch ( MalformedTitleException | RevisionAccessException $e ) {
			return false;
		}
	}
}
