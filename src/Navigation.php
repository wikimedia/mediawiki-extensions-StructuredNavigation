<?php

namespace StructuredNavigation;

/**
 * @license MIT
 */
final class Navigation {
	private array $content;
	private string $titleLabel;
	/** @var NavigationGroup[] */
	private array $groups;

	public function __construct( array $content, string $titleLabel, array $groups ) {
		$this->content = $content;
		$this->titleLabel = $titleLabel;
		$this->groups = $groups;
	}

	public function getContent() : array {
		return $this->content;
	}

	public function getTitleLabel() : string {
		return $this->titleLabel;
	}

	/**
	 * @return NavigationGroup[]
	 */
	public function getGroups() : array {
		return $this->groups;
	}

	/**
	 * @return NavigationGroupLink[]
	 */
	public function getAllLinks() : array {
		$allLinks = [];
		foreach ( $this->groups as $group ) {
			foreach ( $group->getLinks() as $link ) {
				$allLinks[] = $link->getTitle();
			}
		}

		return array_unique( $allLinks );
	}
}
