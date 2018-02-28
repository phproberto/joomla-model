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
 * Methods required by query filterers.
 *
 * @since  __DEPLOY_VERSION__
 */
interface FilterInterface
{
	/**
	 * Filter one or more values received from the state.
	 *
	 * @param   mixed  $values  Values to filter
	 *
	 * @return  array
	 */
	public function filter($values);
}
