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
 * Integer values filterer.
 *
 * @since  __DEPLOY_VERSION__
 */
class Integer extends BaseFilter
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
		return is_int($value);
	}

	/**
	 * Prepare value.
	 *
	 * @param   mixed  $value  Value to prepare
	 *
	 * @return  mixed
	 */
	public function prepareValue($value)
	{
		return (int) parent::prepareValue($value);
	}
}
