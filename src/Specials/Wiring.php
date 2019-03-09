<?php

namespace StructuredNavigation\Specials;

use StructuredNavigation\Services\Services;

/**
 * @license MIT
 */
final class Wiring {

	/**
	 * @return TitlesUsedInNavigation
	 */
	public static function getTitlesUsedInNavigation() : TitlesUsedInNavigation {
		return new TitlesUsedInNavigation(
			self::getServiceInstance()->getQueryTitlesUsedLookup()
		);
	}

	/**
	 * @return NavigationSchemaPage
	 */
	public static function getNavigationSchemaPage() : NavigationSchemaPage {
		return new NavigationSchemaPage(
			self::getServiceInstance()->getSchemaContent()
		);
	}

	/**
	 * @return Services
	 */
	private static function getServiceInstance() : Services {
		return Services::getInstance();
	}

}
