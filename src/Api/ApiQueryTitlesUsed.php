<?php

namespace StructuredNavigation\Api;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\Title\QueryTitlesUsedLookup;

/**
 * @license MIT
 */
final class ApiQueryTitlesUsed extends ApiQueryBase {

	private const PARAM_TITLE = 'title';

	private const PREFIX = 'snqtu';

	/** @var QueryTitlesUsedLookup */
	private $queryTitlesUsedLookup;

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @param QueryTitlesUsedLookup $queryTitlesUsedLookup
	 */
	public function __construct(
		ApiQuery $apiQuery,
		$moduleName,
		QueryTitlesUsedLookup $queryTitlesUsedLookup
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->queryTitlesUsedLookup = $queryTitlesUsedLookup;
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$params = $this->extractRequestParams();
		$title = $params[self::PARAM_TITLE];

		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			[ $title => $this->queryTitlesUsedLookup->getTitlesUsed( $title ) ]
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getAllowedParams() {
		return [
			self::PARAM_TITLE => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function isInternal() {
		return true;
	}

}
