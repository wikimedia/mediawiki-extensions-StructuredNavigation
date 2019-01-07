<?php

namespace StructuredNavigation\Services;

use Config;
use ConfigException;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Renderer\NavigationRenderer;
use UnexpectedValueException;

/**
 * @license GPL-2.0-or-later
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
	 * @return NavigationRenderer
	 */
	public function getNavigationRenderer() : NavigationRenderer {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_RENDERER );
	}
}
