<?php

namespace StructuredNavigation\Api\Action;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\Title\QueryTitlesUsedLookup;

/**
 * This API module allows finding out all the titles used
 * for a given navigation by title.
 *
 * @license MIT
 */
final class ApiQueryTitlesUsed extends ApiQueryBase {
	private const PARAM_TITLE = 'title';
	private const PREFIX = 'snqtu';

	private QueryTitlesUsedLookup $queryTitlesUsedLookup;

	/** @inheritDoc */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		QueryTitlesUsedLookup $queryTitlesUsedLookup
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->queryTitlesUsedLookup = $queryTitlesUsedLookup;
	}

	/** @inheritDoc */
	public function execute() {
		$params = $this->extractRequestParams();
		$title = $params[self::PARAM_TITLE];

		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			[ $title => $this->queryTitlesUsedLookup->getTitlesUsed( $title ) ]
		);
	}

	/** @inheritDoc */
	public function getAllowedParams() {
		return [
			self::PARAM_TITLE => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/** @inheritDoc */
	public function isInternal() {
		return true;
	}

	/** @inheritDoc */
	public function getExamplesMessages() {
		return [
			"action=query&prop={$this->getModuleName()}&snqtutitle=Dontnod_Entertainment"
				=> 'apihelp-query+structurednavigationtitlesused-example',
		];
	}
}
