<?php

namespace StructuredNavigation\Hooks;

use JsonContent;
use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
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

	/** @var AttributeQualifier */
	private $attributeQualifier;

	/** @var NavigationRenderer */
	private $navigationRenderer;

	/** @var TitleParser */
	private $titleParser;

	/**
	 * @param AttributeQualifier $attributeQualifier
	 * @param NavigationRenderer $navigationRenderer
	 * @param TitleParser $titleParser
	 */
	public function __construct(
		AttributeQualifier $attributeQualifier,
		NavigationRenderer $navigationRenderer,
		TitleParser $titleParser
	) {
		$this->attributeQualifier = $attributeQualifier;
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
		$this->attributeQualifier->setAttributes( $renderedNavigation, $title, $attributes );

		return $renderedNavigation;
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
