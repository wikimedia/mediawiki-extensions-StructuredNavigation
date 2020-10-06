<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\DocumentationContent;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\NavigationFactory;
use StructuredNavigation\Schema\NavigationSchemaValidator;
use StructuredNavigation\View\NavigationNotFoundView;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;
use TemplateParser;

/**
 * @license MIT
 */
return [
	'StructuredNavigation.Config'
		=> function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
		},

	'StructuredNavigation.NavigationFactory'
		=> function ( MediaWikiServices $services ) : NavigationFactory {
		return new NavigationFactory(
			$services->getRevisionLookup(),
			$services->getTitleParser()
		);
		},

	'StructuredNavigation.NamespacedTitleSearcher'
		=> function ( MediaWikiServices $services ) : NamespacedTitleSearcher {
		return new NamespacedTitleSearcher( $services->newSearchEngine() );
		},

	'StructuredNavigation.NavigationView'
		=> function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			$services->getLinkRenderer(),
			new TemplateParser(
				$services->getMainConfig()->get( 'ExtensionDirectory' )
				. '/StructuredNavigation/templates'
			)
		);
		},

	'StructuredNavigation.NavigationNotFoundView'
		=> function ( MediaWikiServices $services ) : NavigationNotFoundView {
		$mainConfig = $services->getMainConfig();
		return new NavigationNotFoundView(
			$mainConfig->get( 'ExtensionAssetsPath' ),
			$services->getMessageFormatterFactory()->getTextFormatter(
				$mainConfig->get( 'LanguageCode' )
			)
		);
		},

	'StructuredNavigation.NavigationViewPresenter'
		=> function ( MediaWikiServices $services ) : NavigationViewPresenter {
		$wrapper = new Services( $services );

		return new NavigationViewPresenter(
			$wrapper->getNavigationFactory(),
			$wrapper->getNavigationView()
		);
		},

	'StructuredNavigation.ParserFirstCallInitHandler'
		=> function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		return new ParserFirstCallInitHandler(
			( new Services( $services ) )->getNavigationViewPresenter()
		);
		},

	'StructuredNavigation.DocumentationContent'
		=> function ( MediaWikiServices $services ) : DocumentationContent {
		return new DocumentationContent(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
		},

	'StructuredNavigation.SchemaValidator'
		=> function ( MediaWikiServices $services ) : NavigationSchemaValidator {
		return new NavigationSchemaValidator(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
		}
];
