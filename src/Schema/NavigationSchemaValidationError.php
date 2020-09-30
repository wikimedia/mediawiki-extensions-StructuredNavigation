<?php

namespace StructuredNavigation\Schema;

use Exception;

/**
 * @license MIT
 */
final class NavigationSchemaValidationError extends Exception {
	private array $errors;

	public function __construct( array $errors ) {
		$this->errors = $errors;
	}

	public function getErrors() : array {
		return $this->errors;
	}
}
