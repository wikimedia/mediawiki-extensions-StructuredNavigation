<?php

namespace StructuredNavigation;

/**
 * Represents the JSON from the extension's documentation, which includes
 * the navigation examples and the navigation schema.
 *
 * @license MIT
 */
class DocumentationContent {
	private string $extensionDirectory;

	public function __construct( string $extensionDirectory ) {
		$this->extensionDirectory = $extensionDirectory;
	}

	public function getSchemaContent(): string {
		return file_get_contents( $this->makePath( 'schema/schema.v1.json' ) );
	}

	public function getDecodedSchemaContent(): array {
		return json_decode( $this->getSchemaContent(), true );
	}

	public function getExamples(): array {
		$prefix = $this->makePath( 'examples/' );
		$files = glob( "{$prefix}*.json" );
		$allContent = [];

		foreach ( $files as $file ) {
			$allContent[str_replace( $prefix, '', $file )] =
				json_decode( file_get_contents( $file ) );
		}

		return $allContent;
	}

	private function makePath( string $path ): string {
		return "{$this->extensionDirectory}/StructuredNavigation/docs/{$path}";
	}
}
