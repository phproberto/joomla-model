<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Phproberto\Joomla\Model\State\Filter\StringQuoted;

/**
 * Represents a filtered model state.
 *
 * @since  __DEPLOY_VERSION__
 */
class FilteredState extends State
{
	/**
	 * Get a value from the state.
	 *
	 * @param   string  $key      State property key
	 * @param   mixed   $default  Default value
	 *
	 * @return  mixed
	 */
	public function get($key, $default = null)
	{
		$value = parent::get($key, $default);

		try
		{
			return $this->property($key)->filter($value);
		}
		catch (\RuntimeException $e)
		{
			$filter = new StringQuoted;

			return $filter->filter($value);
		}
	}
}
