<?php

namespace StructuredNavigation\Json;

/**
 * Represents the JSON from the extension's documentation, which includes
 * the navigation examples and the navigation schema.
 *
 * @license MIT
 */
class DocumentationContent {

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
		return file_get_contents( $this->makePath( 'schema/schema.v1.json' ) );
	}

	/**
	 * @return array
	 */
	public function getDecodedSchemaContent() : array {
		return json_decode( $this->getSchemaContent(), true );
	}

	/**
	 * @return array
	 */
	public function getExamples() : array {
		$prefix = $this->makePath( 'examples/' );
		$files = glob( "{$prefix}*.json" );
		$allContent = [];

		foreach ( $files as $file ) {
			$allContent[str_replace( $prefix, '', $file )] =
				json_decode( file_get_contents( $file ) );
		}

		return $allContent;
	}

	/**
	 * @param string $path
	 * @return string
	 */
	private function makePath( string $path ) : string {
		return "{$this->extensionDirectory}/StructuredNavigation/docs/{$path}";
	}

}
