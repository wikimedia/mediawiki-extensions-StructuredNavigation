<?php

namespace StructuredNavigation\Api;

use ApiQuery;
use StructuredNavigation\Services\Services;

/**
 * @license MIT
 */
final class Wiring {

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @return ApiQueryTitlesUsed
	 */
	public static function getApiQueryTitlesUsed( ApiQuery $apiQuery, string $moduleName ) : ApiQueryTitlesUsed {
		return new ApiQueryTitlesUsed(
			$apiQuery,
			$moduleName,
			Services::getInstance()->getQueryTitlesUsedLookup()
		);
	}

}
