<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State;

defined('_JEXEC') || die;

/**
 * Represents a model state property.
 *
 * @since  __DEPLOY_VERSION__
 */
interface PropertyInterface
{
	/**
	 * Can this property be populated from request?
	 *
	 * @return  boolean
	 */
	public function isPopulable();

	/**
	 * Retrieve the property identifier.
	 *
	 * @return  string
	 */
	public function key();
}
