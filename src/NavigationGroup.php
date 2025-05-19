<?php

namespace MediaWiki\Extension\StructuredNavigation;

/**
 * @license MIT
 */
final class NavigationGroup {
	private string $label;
	/** @var NavigationGroupLink[] */
	private array $links;

	public function __construct( string $label, array $links ) {
		$this->label = $label;
		$this->links = $links;
	}

	public function getLabel(): string {
		return $this->label;
	}

	/**
	 * @return NavigationGroupLink[]
	 */
	public function getLinks(): array {
		return $this->links;
	}
}
