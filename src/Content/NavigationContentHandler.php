<?php

namespace MediaWiki\Extension\StructuredNavigation\Content;

use MediaWiki\Content\Content;
use MediaWiki\Content\JsonContentHandler;
use MediaWiki\Content\Renderer\ContentParseParams;
use MediaWiki\Content\ValidationParams;
use MediaWiki\Extension\StructuredNavigation\View\NavigationViewPresenter;
use MediaWiki\Json\FormatJson;
use MediaWiki\Parser\ParserOutput;

/**
 * Content handler for a structured navigation.
 *
 * @license MIT
 */
final class NavigationContentHandler extends JsonContentHandler {
	private NavigationViewPresenter $viewPresenter;

	public function __construct(
		string $modelId,
		NavigationViewPresenter $viewPresenter
	) {
		parent::__construct( $modelId );
		$this->viewPresenter = $viewPresenter;
	}

	/** @inheritDoc */
	protected function getContentClass(): string {
		return NavigationContent::class;
	}

	/** @inheritDoc */
	protected function fillParserOutput(
		Content $content,
		ContentParseParams $parseParams,
		ParserOutput &$parserOutput
	) {
		if ( !( $content instanceof NavigationContent ) ) {
			return false;
		}

		if ( $parseParams->getGenerateHtml() && $content->isValid() ) {
			$parserOutput->setRawText(
				$this->viewPresenter->getFromSource(
					FormatJson::decode( $content->getText(), true )
				)
			);

			$this->viewPresenter->loadModules( $parserOutput );
			$parserOutput->addModules( [ 'ext.structuredNav.content' ] );
		} else {
			$parserOutput->setRawText( '' );
		}
	}

	/** @inheritDoc */
	public function validateSave(
		Content $content,
		ValidationParams $validationParams
	) {
		/** @var NavigationContent $content */
		return $content->isValidStatus();
	}

	/** @inheritDoc */
	public function makeEmptyContent(): NavigationContent {
		return new NavigationContent(
			FormatJson::encode( $this->getPlaceholderContent(), "\t" )
		);
	}

	private function getPlaceholderContent(): array {
		return [
			'config' => [
				'title' => [
					'label' => '',
				],
			],
			'groups' => [
				[
					'title' => [
						'label' => 'Group 1',
					],
					'content' => [
						[ 'Page 1', 'Page with label 1' ],
						[ 'Page 2', 'Page with label 2' ],
						'Page 3 (which uses the title of the page as label)',
					]
				],
			],
		];
	}
}
