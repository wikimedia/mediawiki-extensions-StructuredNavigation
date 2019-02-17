<?php

namespace StructuredNavigation;

use MediaWiki\Linker\LinkRenderer;
use TitleParser;

/**
 * @license MIT
 */
final class NavigationLinkRenderer {

	/** @var LinkRenderer */
	private $linkRenderer;

	/** @var TitleParser */
	private $titleParser;

	/**
	 * @param LinkRenderer $linkRenderer
	 * @param TitleParser $titleParser
	 */
	public function __construct(
		LinkRenderer $linkRenderer,
		TitleParser $titleParser
	) {
		$this->linkRenderer = $linkRenderer;
		$this->titleParser = $titleParser;
	}

	/**
	 * @param array|string $contentTitle
	 * @param array $attributes
	 * @return string
	 */
	public function getLink( $contentTitle, array $attributes = [] ) : string {
		$context = [];

		if ( is_array( $contentTitle ) ) {
			$context = [ 'title' => $contentTitle[0], 'label' => $contentTitle[1] ];
		} else {
			$title = $this->titleParser->parseTitle( $contentTitle );
			$context = [ 'title' => $title, 'label' => $title->getText() ];
		}

		return $this->linkRenderer->makeLink(
			$context['title'], $context['label'], $attributes
		);
	}

}
