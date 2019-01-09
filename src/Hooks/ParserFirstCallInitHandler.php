<?php

namespace StructuredNavigation\Hooks;

use JsonContent;
use OOUI\Tag;
use Parser;
use ParserOutput;
use StructuredNavigation\Json\JsonEntity;
use StructuredNavigation\Renderer\NavigationRenderer;
use Title;
use TitleParser;
use TitleValue;
use WikiPage;

/**
 * @license GPL-2.0-or-later
 */
final class ParserFirstCallInitHandler {

	/** @var string */
	private const PAGE_PROPERTY = 'structurednavigation';

	/** @var NavigationRenderer */
	private $navigationRenderer;

	/** @var TitleParser */
	private $titleParser;

	/**
	 * @param NavigationRenderer $navigationRenderer
	 * @param TitleParser $titleParser
	 */
	public function __construct(
		NavigationRenderer $navigationRenderer,
		TitleParser $titleParser
	) {
		$this->navigationRenderer = $navigationRenderer;
		$this->titleParser = $titleParser;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) : string {
		$title = $this->titleParser->parseTitle( $attributes['title'], NS_NAVIGATION );

		$titleFromTitleValue = Title::newFromTitleValue( $title );
		if ( !$titleFromTitleValue->exists() ) {
			return false;
		}

		$page = WikiPage::factory( $titleFromTitleValue );
		$content = $this->getParsedData( $page->getContent() );

		$parser->enableOOUI();
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $title );
		$this->loadResourceLoaderModules( $parserOutput );

		$renderedNavigation = $this->navigationRenderer->render( $content );
		$this->setAttributes( $renderedNavigation, $title, $attributes );

		return $renderedNavigation;
	}

	/**
	 * Handles setting the attributes of a navigation container. This will
	 * automatically assign the `data-structurednavigation-name` attribute
	 * by default. If the `id` attribute is set by the user, it'll also
	 * assign that as an attribute.
	 *
	 * @param Tag $renderedNavigation
	 * @param TitleValue $title
	 * @param array $attributes
	 * @return void
	 */
	private function setAttributes( Tag $renderedNavigation, TitleValue $title, array $attributes ) : void {
		$renderedNavigation->setAttributes( [
			'data-structurednavigation-name' => htmlspecialchars( $title->getText(), ENT_QUOTES )
		] );

		if ( isset( $attributes['id'] ) ) {
			$renderedNavigation->setAttributes( [
				'id' => htmlspecialchars( $attributes['id'], ENT_QUOTES )
			] );
		}
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
	 * @param TitleValue $title
	 * @return void
	 */
	private function setPageProperty( ParserOutput $parserOutput, TitleValue $title ) : void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, $title->getText() );
	}
}
