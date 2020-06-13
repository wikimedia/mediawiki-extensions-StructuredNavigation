<?php

namespace StructuredNavigation;

/**
 * @license MIT
 */
class Navigation {
	private array $content;
	private array $config;
	private string $titleLabel;
	private array $groups;

	public function __construct( array $content ) {
		$this->content = $content;
		$this->config = $this->content['config'];
		$this->titleLabel = $this->config['title']['label'];
		$this->groups = $this->content['groups'];
	}

	public function getContent() : array {
		return $this->content;
	}

	public function getConfig() : array {
		return $this->config;
	}

	public function getTitleLabel() : string {
		return $this->titleLabel;
	}

	public function getGroups() : array {
		return $this->groups;
	}

	public function getGroupTitleLabel( array $group ) : string {
		return $this->findTitleLabel( $group );
	}

	public function getGroupContent( array $group ) : array {
		return $group['content'];
	}

	private function findTitleLabel( array $item ) : string {
		return $item['title']['label'];
	}
}
