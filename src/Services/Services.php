<?php

namespace StructuredNavigation\Services;

use Config;
use ConfigException;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Json\SchemaContent;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\ContentLinkView;
use StructuredNavigation\View\NavigationView;
use UnexpectedValueException;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * Acts as a convience wrapper around the \MediaWiki\MediaWikiServices
 * object for retrieving services specific to this extension. This allows
 * the consumer to not have to know the unique service key of the specific
 * service - they can just call a method for what they want.
 *
 * @license MIT
 */
final class Services {

	/** @var MediaWikiServices */
	private $services;

	/**
	 * @param MediaWikiServices $services
	 */
	public function __construct( MediaWikiServices $services ) {
		$this->services = $services;
	}

	/**
	 * @return Services
	 */
	public static function getInstance() : Services {
		return new self( MediaWikiServices::getInstance() );
	}

	/**
	 * @throws ConfigException|UnexpectedValueException
	 * @return Config
	 */
	public function getConfig() : Config {
		return $this->services->getService( Constants::SERVICE_CONFIG );
	}

	/**
	 * @return JsonEntityFactory
	 */
	public function getJsonEntityFactory() : JsonEntityFactory {
		return $this->services->getService( Constants::SERVICE_JSON_ENTITY_FACTORY );
	}

	/**
	 * @return ContentLinkView
	 */
	public function getContentLinkView() : ContentLinkView {
		return $this->services->getService( Constants::SERVICE_CONTENT_LINK_VIEW );
	}

	/**
	 * @return NamespacedTitleSearcher
	 */
	public function getNamespacedTitleSearcher() : NamespacedTitleSearcher {
		return $this->services->getService( Constants::SERVICE_NAMESPACED_TITLE_SEARCHER );
	}

	/**
	 * @return NavigationTitleValue
	 */
	public function getNavigationTitleValue() : NavigationTitleValue {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_TITLE_VALUE );
	}

	/**
	 * @return NavigationView
	 */
	public function getNavigationView() : NavigationView {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_VIEW );
	}

	/**
	 * @return NavigationViewPresenter
	 */
	public function getNavigationViewPresenter() : NavigationViewPresenter {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_VIEW_PRESENTER );
	}

	/**
	 * @return ParserFirstCallInitHandler
	 */
	public function getParserFirstCallInitHandler() : ParserFirstCallInitHandler {
		return $this->services->getService(
			Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER
		);
	}

	/**
	 * @return QueryTitlesUsedLookup
	 */
	public function getQueryTitlesUsedLookup() : QueryTitlesUsedLookup {
		return $this->services->getService(
			Constants::SERVICE_QUERY_TITLES_USED_LOOKUP
		);
	}

	/**
	 * @return SchemaContent
	 */
	public function getSchemaContent() : SchemaContent {
		return $this->services->getService( Constants::SERVICE_SCHEMA_CONTENT );
	}

}
