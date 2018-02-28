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
 * Boolean values filterer.
 *
 * @since  __DEPLOY_VERSION__
 */
class Boolean extends BaseFilter
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
		return in_array($value, [true, false], true);
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

		if ('true' === $value)
		{
			return true;
		}

		if ('false' === $value)
		{
			return false;
		}

		if (!in_array($value, [1,0,'1','0', true,false], true))
		{
			return null;
		}

		return (bool) $value;
	}
}
