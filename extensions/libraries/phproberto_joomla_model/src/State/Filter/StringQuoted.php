<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State\Filter
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State\Filter;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Filter to quote strings.
 *
 * @since  __DEPLOY_VERSION__
 */
class StringQuoted extends StringFilter
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
		$value = (string) $value;

		return "'" === $value[0] && "'" === $value[strlen($value) - 1];
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
		$value = parent::prepareValue($value);

		if (!is_string($value))
		{
			return null;
		}

		return $this->getDbo()->quote($value);
	}

	/**
	 * Isolated factory communication to ease testing.
	 *
	 * @return  \JDatabaseDriver
	 */
	protected function getDbo()
	{
		return Factory::getDbo();
	}
}
