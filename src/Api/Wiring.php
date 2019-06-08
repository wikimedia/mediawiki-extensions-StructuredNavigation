<?php

namespace StructuredNavigation\Api;

use ApiQuery;
use StructuredNavigation\Services\Services;

/**
 * Factory-based registration of API modules.
 *
 * @license MIT
 */
final class Wiring {

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @return ApiMetaNavigationSchema
	 */
	public static function getApiMetaNavigationSchema( ApiQuery $apiQuery, string $moduleName ) : ApiMetaNavigationSchema {
		return new ApiMetaNavigationSchema(
			$apiQuery,
			$moduleName,
			Services::getInstance()->getSchemaContent()
		);
	}

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
		return new ApiQueryNavigationHtml(
			$apiQuery,
			$moduleName,
			Services::getInstance()->getNavigationViewPresenter()
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
