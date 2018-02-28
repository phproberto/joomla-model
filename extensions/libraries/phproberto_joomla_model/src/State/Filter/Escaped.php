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

use Joomla\CMS\Factory;

/**
 * Strings escaped by database driver.
 *
 * @since  __DEPLOY_VERSION__
 */
class Escaped extends StringFilter
{
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

		return $this->getDbo()->escape($value);
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
