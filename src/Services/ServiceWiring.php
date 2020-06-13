<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\DocumentationContent;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\ContentLinkView;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @license MIT
 */

return [
	'StructuredNavigation.Config'
		=> function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
		},

	'StructuredNavigation.ContentLinkView'
		=> function ( MediaWikiServices $services ) : ContentLinkView {
		return new ContentLinkView(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
		},

	'StructuredNavigation.JsonEntityFactory'
		=> function ( MediaWikiServices $services ) : JsonEntityFactory {
		return new JsonEntityFactory(
			( new Services( $services ) )->getNavigationTitleValue()
		);
		},

	'StructuredNavigation.NamespacedTitleSearcher'
		=> function ( MediaWikiServices $services ) : NamespacedTitleSearcher {
		return new NamespacedTitleSearcher( $services->newSearchEngine() );
		},

	'StructuredNavigation.NavigationTitleValue'
		=> function ( MediaWikiServices $services ) : NavigationTitleValue {
		return new NavigationTitleValue( $services->getTitleParser() );
		},

	'StructuredNavigation.NavigationView'
		=> function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			( new Services( $services ) )->getContentLinkView()
		);
		},

	'StructuredNavigation.NavigationViewPresenter'
		=> function ( MediaWikiServices $services ) : NavigationViewPresenter {
		$wrapper = new Services( $services );

		return new NavigationViewPresenter(
			$wrapper->getJsonEntityFactory(),
			$wrapper->getNavigationView()
		);
		},

	'StructuredNavigation.ParserFirstCallInitHandler'
		=> function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			( new Services( $services ) )->getNavigationViewPresenter()
		);
		},

	'StructuredNavigation.QueryTitlesUsedLookup'
		=> function ( MediaWikiServices $services ) : QueryTitlesUsedLookup {
		return new QueryTitlesUsedLookup(
			( new Services( $services ) )->getJsonEntityFactory()
		);
		},

	'StructuredNavigation.DocumentationContent'
		=> function ( MediaWikiServices $services ) : DocumentationContent {
		return new DocumentationContent(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
		},
];
