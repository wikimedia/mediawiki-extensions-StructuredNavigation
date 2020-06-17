<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\DocumentationContent;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\NavigationFactory;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationNotFoundView;
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
	private MediaWikiServices $services;

	public function __construct( MediaWikiServices $services ) {
		$this->services = $services;
	}

	public static function getInstance() : Services {
		return new self( MediaWikiServices::getInstance() );
	}

	public function getConfig() : Config {
		return $this->services->getService( 'StructuredNavigation.Config' );
	}

	public function getNavigationFactory() : NavigationFactory {
		return $this->services->getService( 'StructuredNavigation.NavigationFactory' );
	}

	public function getNamespacedTitleSearcher() : NamespacedTitleSearcher {
		return $this->services->getService( 'StructuredNavigation.NamespacedTitleSearcher' );
	}

	public function getNavigationView() : NavigationView {
		return $this->services->getService( 'StructuredNavigation.NavigationView' );
	}

	public function getNavigationNotFoundView() : NavigationNotFoundView {
		return $this->services->getService( 'StructuredNavigation.NavigationNotFoundView' );
	}

	public function getNavigationViewPresenter() : NavigationViewPresenter {
		return $this->services->getService( 'StructuredNavigation.NavigationViewPresenter' );
	}

	public function getParserFirstCallInitHandler() : ParserFirstCallInitHandler {
		return $this->services->getService( 'StructuredNavigation.ParserFirstCallInitHandler' );
	}

	public function getDocumentationContent() : DocumentationContent {
		return $this->services->getService( 'StructuredNavigation.DocumentationContent' );
	}
}
