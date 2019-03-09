<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Json\SchemaContent;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\ContentLinkView;
use StructuredNavigation\View\NavigationView;

/**
 * @license MIT
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( Constants::CONFIG_NAME );
	},

	Constants::SERVICE_CONTENT_LINK_VIEW => function ( MediaWikiServices $services ) : ContentLinkView {
		return new ContentLinkView(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},

	Constants::SERVICE_JSON_ENTITY_FACTORY => function ( MediaWikiServices $services ) : JsonEntityFactory {
		return new JsonEntityFactory(
			( new Services( $services ) )->getNavigationTitleValue()
		);
	},

	Constants::SERVICE_NAVIGATION_TITLE_VALUE => function ( MediaWikiServices $services ) : NavigationTitleValue {
		return new NavigationTitleValue( $services->getTitleParser() );
	},

	Constants::SERVICE_NAVIGATION_VIEW => function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			( new Services( $services ) )->getContentLinkView()
		);
	},

	Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER => function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		$wrapper = new Services( $services );

		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			$wrapper->getJsonEntityFactory(),
			$wrapper->getNavigationView()
		);
	},

	Constants::SERVICE_QUERY_TITLES_USED_LOOKUP => function ( MediaWikiServices $services ) : QueryTitlesUsedLookup {
		return new QueryTitlesUsedLookup(
			( new Services( $services ) )->getJsonEntityFactory()
		);
	},

	Constants::SERVICE_SCHEMA_CONTENT => function ( MediaWikiServices $services ) : SchemaContent {
		return new SchemaContent(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
	},

];
