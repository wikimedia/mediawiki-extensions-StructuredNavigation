<?php

namespace StructuredNavigation\Libs\MediaWiki\Exception;

use User;
use UserBlockedError;

/**
 * @todo Should submit a patch upstream eventually to merge this function
 * into the \SpecialPage class.
 *
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
trait CheckUserBlockedTrait {

	/**
	 * @param User $user
	 * @throws UserBlockedError
	 * @return void
	 */
	public function checkIsUserBlocked( User $user ) : void {
		if ( $user->isBlocked() ) {
			throw new UserBlockedError( $user->getBlock() );
		}
	}
}
