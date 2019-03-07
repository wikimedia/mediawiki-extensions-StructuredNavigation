<?php

namespace StructuredNavigation\Api;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\Json\JsonEntityFactory;

/**
 * @license MIT
 */
final class ApiQueryNavigationData extends ApiQueryBase {

	private const PARAM_TITLE = 'title';

	private const PREFIX = 'snqnd';

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @param JsonEntityFactory $jsonEntityFactory
	 */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		JsonEntityFactory $jsonEntityFactory
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->jsonEntityFactory = $jsonEntityFactory;
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
			[ $title => $this->jsonEntityFactory->newFromTitle( $title )->getContent() ]
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
