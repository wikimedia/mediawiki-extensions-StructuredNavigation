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
	 * @return ApiQueryNavigationData
	 */
	public static function getApiQueryNavigationData( ApiQuery $apiQuery, string $moduleName ) : ApiQueryNavigationData {
		return new ApiQueryNavigationData(
			$apiQuery,
			$moduleName,
			Services::getInstance()->getJsonEntityFactory()
		);
	}

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @return ApiQueryNavigationHtml
	 */
	public static function getApiQueryNavigationHtml( ApiQuery $apiQuery, string $moduleName ) : ApiQueryNavigationHtml {
		$service = Services::getInstance();

		return new ApiQueryNavigationHtml(
			$apiQuery,
			$moduleName,
			$service->getJsonEntityFactory(),
			$service->getNavigationView()
		);
	}

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