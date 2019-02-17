<?php

namespace StructuredNavigation\Json;

/**
 * An immutable convience wrapper around a JSON object that's been decoded
 * into an associative array. This allows outside users not having
 * to know what the actual array key name is, you can just retrieve it
 * using these methods. If the schema internally changes such as a rename
 * of a key, this object would hide that implementation detail and
 * nothing would break for outside users (probably)
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
