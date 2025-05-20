<?php

namespace MediaWiki\Extension\StructuredNavigation\Schema;

use JsonSchema\Validator;
use MediaWiki\Extension\StructuredNavigation\DocumentationContent;
use MediaWiki\Status\Status;

/**
 * @license MIT
 */
final class NavigationValidator {
	private DocumentationContent $documentationContent;

	public function __construct( DocumentationContent $documentationContent ) {
		$this->documentationContent = $documentationContent;
	}

	public function validate( $data ): Status {
		$validator = new Validator();
		$schemaPath = $this->documentationContent->getSchemaPath();
		$validator->validate(
			$data,
			[
				'$ref' => "file://{$schemaPath}"
			]
		);
		if ( $validator->isValid() ) {
			return Status::newGood();
		}

		$errors = [];
		foreach ( $validator->getErrors() as $error ) {
			$errors[] = "[{$error['property']}] {$error['message']}\n";
		}

		return Status::newFatal(
			'structurednav-schema-invalid',
			implode( "\n", $errors )
		);
	}
}
