<?php

namespace StructuredNavigation\View;

use MediaWiki\Linker\LinkRenderer;
use TitleParser;

/**
 * @license MIT
 */
final class ContentLinkView {

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
	 * @param string|array $contentTitle
	 * @param array $attributes
	 * @return string
	 */
	public function getLink( $contentTitle, array $attributes = [] ) : string {
		if ( is_array( $contentTitle ) ) {
			$parsedTitle = $this->titleParser->parseTitle( $contentTitle[0] );
			$label = $contentTitle[1];
		} else {
			$parsedTitle = $this->titleParser->parseTitle( $contentTitle );
			$label = $parsedTitle->getText();
		}

		return $this->linkRenderer->makeLink( $parsedTitle, $label, $attributes );
	}

}
