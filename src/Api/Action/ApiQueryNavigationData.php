<?php

namespace StructuredNavigation\Api\Action;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\NavigationFactory;

/**
 * This API module allows querying the JSON of a given navigation
 * by its title in the Navigation namespace. The namespace is
 * already assumed, and the consumer only has to pass the title text.
 *
 * @license MIT
 */
final class ApiQueryNavigationData extends ApiQueryBase {
	private const PARAM_TITLE = 'title';
	private const PREFIX = 'snqnd';

	private NavigationFactory $navigationFactory;

	/** @inheritDoc */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		NavigationFactory $navigationFactory
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->navigationFactory = $navigationFactory;
	}

	/** @inheritDoc */
	public function execute() {
		$params = $this->extractRequestParams();
		$title = $params[self::PARAM_TITLE];

		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			[ $title => $this->navigationFactory->newFromTitle( $title )->getContent() ]
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
			"action=query&prop={$this->getModuleName()}&snqndtitle=Dontnod_Entertainment"
				=> 'apihelp-query+structurednavigationnavigationdata-example',
		];
	}
}
