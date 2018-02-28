<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State\Filter
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State\Filter;

defined('_JEXEC') || die;

/**
 * IntegerBoolean filter. Boolean in binary state: 0 (false) | 1 (true).
 *
 * @since  __DEPLOY_VERSION__
 */
class IntegerBoolean extends Boolean
{
	/**
	 * Determine if a value will be used or not.
	 *
	 * @param   mixed  $value  Value to filter
	 *
	 * @return  boolean
	 */
	protected function filterValue($value)
	{
		return in_array($value, [0,1], true);
	}

	/**
	 * Prepare a value before applying filter.
	 *
	 * @param   mixed  $value  Value to prepare
	 *
	 * @return  mixed
	 */
	protected function prepareValue($value)
	{
		$value = parent::prepareValue($value);

		return null === $value ? null : (int) $value;
	}
}
