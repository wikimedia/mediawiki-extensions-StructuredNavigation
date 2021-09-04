<?php

namespace StructuredNavigation\Schema;

use JsonSchema\Validator;

/**
 * @license MIT
 */
final class NavigationSchemaValidator {
	private string $extensionDirectory;

	public function __construct( string $extensionDirectory ) {
		$this->extensionDirectory = $extensionDirectory;
	}

	public function validate( $data ) {
		$validator = new Validator();
		$validator->validate( $data, [ '$ref' => "file://{$this->getSchema()}" ] );
		if ( $validator->isValid() ) {
			return true;
		}

		$errors = [];
		foreach ( $validator->getErrors() as $error ) {
			$errors[] = "[{$error['property']}] {$error['message']}\n";
		}

		throw new NavigationSchemaValidationError( $errors );
	}

	private function getSchema(): string {
		return "{$this->extensionDirectory}/StructuredNavigation/docs/schema/schema.v1.json";
	}
}
