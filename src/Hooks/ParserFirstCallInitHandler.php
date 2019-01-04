<?php

namespace StructuredNavigation\Hooks;

use JsonContent;
use Parser;
use ParserOutput;
use StructuredNavigation\Constants;
use StructuredNavigation\Json\JsonEntity;
use StructuredNavigation\Renderer\NavigationRenderer;
use Title;
use WikiPage;

/**
 * @license GPL-2.0-or-later
 */
final class ParserFirstCallInitHandler {

	/** @var NavigationRenderer */
	private $navigationRenderer;

	/**
	 * @param NavigationRenderer $navigationRenderer
	 */
	public function __construct( NavigationRenderer $navigationRenderer ) {
		$this->navigationRenderer = $navigationRenderer;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( $input, array $attributes, Parser $parser ) : string {
		$title = Title::makeTitle( NS_NAVIGATION, $attributes['title'] );

		if ( !$title->exists() ) {
			return false;
		}

		$page = WikiPage::factory( $title );
		$content = $this->getParsedData( $page->getContent() );

		$parser->enableOOUI();
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $title->getArticleID() );
		$this->loadResourceLoaderModules( $parserOutput );

		return $this->navigationRenderer->render( $content );
	}

	/**
	 * @param JsonContent $content
	 * @return JsonEntity
	 */
	private function getParsedData( JsonContent $content ) : JsonEntity {
		return new JsonEntity( $content->getJsonData() );
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @return void
	 */
	private function loadResourceLoaderModules( ParserOutput $parserOutput ) : void {
		$parserOutput->addModuleStyles( [
			'ext.structurednavigation.ui.structurednavigation.styles',
			'ext.structurednavigation.ui.structurednavigation.separator.styles'
		] );
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @param int $articleId
	 * @return void
	 */
	private function setPageProperty( ParserOutput $parserOutput, int $articleId ) : void {
		$parserOutput->setProperty( Constants::PAGE_PROPERTY, $articleId );
	}
}
