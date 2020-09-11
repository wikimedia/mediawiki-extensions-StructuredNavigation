<?php

namespace StructuredNavigation;

use FormatJson;
use Title;
use TitleParser;
use WikiPage;

/**
 * @license MIT
 */
final class NavigationFactory {
	private TitleParser $titleParser;

	public function __construct( TitleParser $titleParser ) {
		$this->titleParser = $titleParser;
	}

	public function newFromSource( array $source ) : Navigation {
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
		$title = Title::newFromLinkTarget(
			$this->titleParser->parseTitle( $passedTitle, NS_NAVIGATION ) );

		if ( !$title->exists() ) {
			return false;
		}

		return $this->newFromSource(
			FormatJson::decode(
				WikiPage::factory( $title )->getContent()->getNativeData(), true
			)
		);
	}

	private function parseNavigationLink( $stringOrArrayLink ) : NavigationGroupLink {
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
