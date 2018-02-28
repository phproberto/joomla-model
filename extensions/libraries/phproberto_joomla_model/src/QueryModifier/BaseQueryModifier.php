<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  QueryModifier
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\QueryModifier;

defined('_JEXEC') || die;

use Joomla\CMS\Factory;

/**
 * Base query modifier.
 *
 * @since  __DEPLOY_VERSION__
 */
abstract class BaseQueryModifier
{
	/**
	 * Callback to execute if there are values found.
	 *
	 * @var  callable|null
	 */
	protected $callback;

	/**
	 * Query to modify.
	 *
	 * @var  \JDatabaseQuery\
	 */
	protected $query;

	/**
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query     Query to modify
	 * @param   callable|null    $callback  Callback to execute if there are values found.
	 */
	public function __construct(\JDatabaseQuery$query, callable $callback = null)
	{
		$this->callback = $callback;
		$this->query = $query;
	}

	/**
	 * Execute the callback.
	 *
	 * @return  void
	 */
	protected function callback()
	{
		if ($this->callback)
		{
			call_user_func_array($this->callback, array($this->query));
		}
	}

	/**
	 * Isolated factory communication to ease testing.
	 *
	 * @return  \JDatabaseDriver
	 *
	 * @codeCoverageIgnore
	 */
	protected function getDbo()
	{
		return Factory::getDbo();
	}
}
