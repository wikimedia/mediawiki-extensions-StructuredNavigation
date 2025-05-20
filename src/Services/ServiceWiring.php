<?php

namespace MediaWiki\Extension\StructuredNavigation\Services;

use MediaWiki\Config\Config;
use MediaWiki\Extension\StructuredNavigation\DocumentationContent;
use MediaWiki\Extension\StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use MediaWiki\Extension\StructuredNavigation\Libs\NamespacedTitleSearcher;
use MediaWiki\Extension\StructuredNavigation\NavigationFactory;
use MediaWiki\Extension\StructuredNavigation\Schema\NavigationValidator;
use MediaWiki\Extension\StructuredNavigation\View\NavigationNotFoundView;
use MediaWiki\Extension\StructuredNavigation\View\NavigationView;
use MediaWiki\Extension\StructuredNavigation\View\NavigationViewPresenter;
use MediaWiki\Html\TemplateParser;
use MediaWiki\MediaWikiServices;

/**
 * @license MIT
 */
return [
	'StructuredNavigation.Config'
		=> static function ( MediaWikiServices $services ): Config {
			return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
		},

	'StructuredNavigation.NavigationFactory'
		=> static function ( MediaWikiServices $services ): NavigationFactory {
			return new NavigationFactory(
				$services->getRevisionLookup(),
				$services->getTitleParser()
			);
		},

	'StructuredNavigation.NamespacedTitleSearcher'
		=> static function ( MediaWikiServices $services ): NamespacedTitleSearcher {
			return new NamespacedTitleSearcher(
				$services->newSearchEngine(),
				$services->getTitleFactory()
			);
		},

	'StructuredNavigation.NavigationView'
		=> static function ( MediaWikiServices $services ): NavigationView {
			return new NavigationView(
				$services->getLinkRenderer(),
				new TemplateParser(
					$services->getMainConfig()->get( 'ExtensionDirectory' )
					. '/StructuredNavigation/templates'
				)
			);
		},

	'StructuredNavigation.NavigationNotFoundView'
		=> static function ( MediaWikiServices $services ): NavigationNotFoundView {
			$mainConfig = $services->getMainConfig();
			return new NavigationNotFoundView(
				$mainConfig->get( 'ExtensionAssetsPath' ),
				$services->getMessageFormatterFactory()->getTextFormatter(
					$mainConfig->get( 'LanguageCode' )
				)
			);
		},

	'StructuredNavigation.NavigationViewPresenter'
		=> static function ( MediaWikiServices $services ): NavigationViewPresenter {
			$wrapper = new Services( $services );

			return new NavigationViewPresenter(
				$wrapper->getNavigationFactory(),
				$wrapper->getNavigationView()
			);
		},

	'StructuredNavigation.ParserFirstCallInitHandler'
		=> static function ( MediaWikiServices $services ): ParserFirstCallInitHandler {
			return new ParserFirstCallInitHandler(
				( new Services( $services ) )->getNavigationViewPresenter()
			);
		},

	'StructuredNavigation.DocumentationContent'
		=> static function ( MediaWikiServices $services ): DocumentationContent {
			return new DocumentationContent(
				$services->getMainConfig()->get( 'ExtensionDirectory' )
			);
		},

	'StructuredNavigation.NavigationValidator'
		=> static function ( MediaWikiServices $services ): NavigationValidator {
			$wrapper = new Services( $services );

			return new NavigationValidator(
				$wrapper->getDocumentationContent()
			);
		}
];
