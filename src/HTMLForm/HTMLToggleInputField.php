<?php

namespace StructuredNavigation\HTMLForm;

use HTMLFormField;
use StructuredNavigation\Libs\OOUI\ToggleSwitchInputWidget;

/**
 * @todo Move this somewhere into /libs?
 * @license GPL-2.0-or-later
 */
class HTMLToggleInputField extends HTMLFormField {

	/**
	 * @param string $value
	 * @return string
	 */
	public function getInputHTML( $value ) {
		return '';
	}

	/**
	 * @param string $value
	 * @return ToggleSwitchInputWidget
	 */
	public function getInputOOUI( $value ) : ToggleSwitchInputWidget {
		$this->mParent->getOutput()->addModuleStyles( [
			'ext.structurednavigation.libs.ooui.toggleswitchinputwidget.styles'
		] );

		return new ToggleSwitchInputWidget();
	}

	/**
	 * @return string
	 */
	protected function getLabelAlignOOUI() : string {
		return 'left';
	}
}
