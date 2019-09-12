<?php

namespace StructuredNavigation\Services;

use Config;
use ConfigException;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\DocumentationContent;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\ContentLinkView;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;
use UnexpectedValueException;

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
		return $this->services->getService( 'StructuredNavigation.Config' );
	}

	/**
	 * @return ContentLinkView
	 */
	public function getContentLinkView() : ContentLinkView {
		return $this->services->getService( 'StructuredNavigation.ContentLinkView' );
	}

	/**
	 * @return JsonEntityFactory
	 */
	public function getJsonEntityFactory() : JsonEntityFactory {
		return $this->services->getService( 'StructuredNavigation.JsonEntityFactory' );
	}

	/**
	 * @return NamespacedTitleSearcher
	 */
	public function getNamespacedTitleSearcher() : NamespacedTitleSearcher {
		return $this->services->getService( 'StructuredNavigation.NamespacedTitleSearcher' );
	}

	/**
	 * @return NavigationTitleValue
	 */
	public function getNavigationTitleValue() : NavigationTitleValue {
		return $this->services->getService( 'StructuredNavigation.NavigationTitleValue' );
	}

	/**
	 * @return NavigationView
	 */
	public function getNavigationView() : NavigationView {
		return $this->services->getService( 'StructuredNavigation.NavigationView' );
	}

	/**
	 * @return NavigationViewPresenter
	 */
	public function getNavigationViewPresenter() : NavigationViewPresenter {
		return $this->services->getService( 'StructuredNavigation.NavigationViewPresenter' );
	}

	/**
	 * @return ParserFirstCallInitHandler
	 */
	public function getParserFirstCallInitHandler() : ParserFirstCallInitHandler {
		return $this->services->getService( 'StructuredNavigation.ParserFirstCallInitHandler' );
	}

	/**
	 * @return QueryTitlesUsedLookup
	 */
	public function getQueryTitlesUsedLookup() : QueryTitlesUsedLookup {
		return $this->services->getService( 'StructuredNavigation.QueryTitlesUsedLookup' );
	}

	/**
	 * @return DocumentationContent
	 */
	public function getDocumentationContent() : DocumentationContent {
		return $this->services->getService( 'StructuredNavigation.DocumentationContent' );
	}

}
