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
 * Methods required by query filterers.
 *
 * @since  __DEPLOY_VERSION__
 */
interface StateInterface
{
	/**
	 * Get a value from the state.
	 *
	 * @param   string  $key      Property key
	 * @param   mixed   $default  Default value
	 *
	 * @return  mixed
	 */
	public function get($key, $default = null);

	/**
	 * Set a value of a state property.
	 *
	 * @param   string  $key    Property key
	 * @param   mixed   $value  Value for the state property
	 *
	 * @return  mixed  The previous value of the property or null if not set.
	 */
	public function set($key, $value);
}
