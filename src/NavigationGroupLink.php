<?php

namespace StructuredNavigation;

use TitleValue;

/**
 * @license MIT
 */
final class NavigationGroupLink {
	private TitleValue $titleValue;
	private string $title;
	private string $label;

	public function __construct( TitleValue $titleValue, string $title, string $label = null ) {
		$this->titleValue = $titleValue;
		$this->title = $title;
		$this->label = $label ?? $this->title;
	}

	public function getTitleValue() : TitleValue {
		return $this->titleValue;
	}

	public function getTitle() : string {
		return $this->title;
	}

	public function getLabel() : string {
		return $this->label;
	}
}
