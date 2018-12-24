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
 * @license GPL-2.0-or-later
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
	 * @return string
	 */
	public function getName() : string {
		return $this->content['name'];
	}

	/**
	 * @return array
	 */
	public function getConfig() : array {
		return $this->content['config'];
	}

	/**
	 * @return array
	 */
	public function getGroups() : array {
		return $this->content['groups'];
	}

	/**
	 * @param array
	 * @return string
	 */
	public function getGroupTitle( array $group ) : string {
		return $group['title']['label'];
	}

	/**
	 * @param array
	 * @return array
	 */
	public function getGroupContent( array $group ) : array {
		return $group['content'];
	}
}
