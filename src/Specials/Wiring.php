<?php

namespace StructuredNavigation\Specials;

use StructuredNavigation\Services\Services;

/**
 * Factory-based registration of special pages.
 *
 * @license MIT
 */
final class Wiring {

	/**
	 * @return TitlesUsedInNavigation
	 */
	public static function getTitlesUsedInNavigation() : TitlesUsedInNavigation {
		$service = self::getServiceInstance();
		return new TitlesUsedInNavigation(
			$service->getQueryTitlesUsedLookup(),
			$service->getNamespacedTitleSearcher(),
			$service->getNavigationTitleValue()
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
