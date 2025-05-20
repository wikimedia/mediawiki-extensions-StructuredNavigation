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
use MediaWiki\MediaWikiServices;

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

	public static function getInstance(): Services {
		return new self( MediaWikiServices::getInstance() );
	}

	public function getConfig(): Config {
		return $this->services->getService( 'StructuredNavigation.Config' );
	}

	public function getNavigationFactory(): NavigationFactory {
		return $this->services->getService( 'StructuredNavigation.NavigationFactory' );
	}

	public function getNamespacedTitleSearcher(): NamespacedTitleSearcher {
		return $this->services->getService( 'StructuredNavigation.NamespacedTitleSearcher' );
	}

	public function getNavigationView(): NavigationView {
		return $this->services->getService( 'StructuredNavigation.NavigationView' );
	}

	public function getNavigationNotFoundView(): NavigationNotFoundView {
		return $this->services->getService( 'StructuredNavigation.NavigationNotFoundView' );
	}

	public function getNavigationViewPresenter(): NavigationViewPresenter {
		return $this->services->getService( 'StructuredNavigation.NavigationViewPresenter' );
	}

	public function getParserFirstCallInitHandler(): ParserFirstCallInitHandler {
		return $this->services->getService( 'StructuredNavigation.ParserFirstCallInitHandler' );
	}

	public function getDocumentationContent(): DocumentationContent {
		return $this->services->getService( 'StructuredNavigation.DocumentationContent' );
	}

	public function getNavigationValidator(): NavigationValidator {
		return $this->services->getService( 'StructuredNavigation.NavigationValidator' );
	}
}
