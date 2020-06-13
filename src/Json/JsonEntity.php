<?php

namespace StructuredNavigation\Json;

/**
 * This provides basic read access to a navigation's JSON
 * which is assumed to have been decoded into an associative
 * PHP array.
 *
 * @license MIT
 */
final class JsonEntity {
	/** @var array */
	private $content;

	/**
	 * @param array $content
	 */
	public function __construct( array $content ) {
		$this->content = $content;
	}

	/**
	 * Returns the entire JSON blob. This should only be used
	 * if you need access to the **entire** blob at once. If
	 * you need more specific details, you should be calling
	 * the other methods instead.
	 *
	 * @return array
	 */
	public function getContent() : array {
		return $this->content;
	}

	/**
	 * @return array
	 */
	public function getConfig() : array {
		return $this->content['config'];
	}

	/**
	 * @return string
	 */
	public function getTitleLabel() : string {
		return $this->findTitleLabel( $this->getConfig() );
	}

	/**
	 * @return array
	 */
	public function getGroups() : array {
		return $this->content['groups'];
	}

	/**
	 * @param array $group
	 * @return string
	 */
	public function getGroupTitleLabel( array $group ) : string {
		return $this->findTitleLabel( $group );
	}

	/**
	 * @param array $group
	 * @return array
	 */
	public function getGroupContent( array $group ) : array {
		return $group['content'];
	}

	/**
	 * @param array $item
	 * @return string
	 */
	private function findTitleLabel( array $item ) : string {
		return $item['title']['label'];
	}
}
