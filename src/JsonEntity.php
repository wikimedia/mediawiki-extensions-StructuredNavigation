<?php

namespace StructuredNavigation;

/**
 * An immutable convience wrapper around a JSON object that's been decoded
 * into an associative array. This allows outside users not having
 * to know what the actual array key name is, you can just retrieve it
 * using these methods.
 *
 * @license GPL-2.0-or-later
 */
class JsonEntity {

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
	 * @param string $group
	 * @return array
	 */
	public function getContentForGroup( string $group ) : array {
		return $this->getGroups()[$group]['content'];
	}
}
