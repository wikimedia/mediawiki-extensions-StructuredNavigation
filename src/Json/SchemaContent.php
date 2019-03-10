<?php

namespace StructuredNavigation\Json;

/**
 * Represents the content of the JSON schema used by this extension.
 *
 * @license MIT
 */
class SchemaContent {

	/** @var string */
	private $extensionDirectory;

	/**
	 * @param string $extensionDirectory
	 */
	public function __construct( string $extensionDirectory ) {
		$this->extensionDirectory = $extensionDirectory;
	}

	/**
	 * @return string
	 */
	public function getSchemaContent() : string {
		return file_get_contents(
			$this->extensionDirectory . '/StructuredNavigation/docs/schema/schema.v1.json'
		);
	}

}
