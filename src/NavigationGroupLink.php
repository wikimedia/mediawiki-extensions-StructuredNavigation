<?php

namespace MediaWiki\Extension\StructuredNavigation;

use MediaWiki\Linker\LinkRenderer;
use MediaWiki\Title\MalformedTitleException;
use MediaWiki\Title\TitleParser;
use MediaWiki\Title\TitleValue;

/**
 * @license MIT
 */
final class NavigationGroupLink {
	private TitleValue $titleValue;
	private string $title;
	private string $label;

	public function __construct( TitleValue $titleValue, string $title, ?string $label = null ) {
		$this->titleValue = $titleValue;
		$this->title = $title;
		$this->label = $label ?? $this->title;
	}

	/**
	 * @todo Refactor to return Status so it's more informative
	 * @param TitleParser $titleParser
	 * @param string|list{string, string} $link
	 * @return NavigationGroupLink|null
	 */
	public static function parseOrNull( TitleParser $titleParser, $link ): ?self {
		try {
			if ( is_array( $link ) && count( $link ) === 2 ) {
				$title = $link[0];
				$label = $link[1];
				$titleValue = $titleParser->parseTitle( $title );
				return new NavigationGroupLink( $titleValue, $title, $label );
			} else {
				$title = $link;
				$titleValue = $titleParser->parseTitle( $title );
				return new NavigationGroupLink( $titleValue, $title );
			}
		} catch ( MalformedTitleException $e ) {
			return null;
		}
	}

	public function asHtmlLink( LinkRenderer $linkRenderer ): string {
		return $linkRenderer->makeLink(
			$this->getTitleValue(),
			$this->getLabel(),
			[ 'class' => 'mw-structurednav-group-content-link' ]
		);
	}

	public function getTitleValue(): TitleValue {
		return $this->titleValue;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getLabel(): string {
		return $this->label;
	}
}
