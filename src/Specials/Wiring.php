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
	public static function onTitlesUsedInNavigation() : TitlesUsedInNavigation {
		return new TitlesUsedInNavigation(
			self::getServiceInstance()->getQueryTitlesUsedLookup()
		);
	}

	/**
	 * @return Services
	 */
	private static function getServiceInstance() : Services {
		return Services::getInstance();
	}

}
