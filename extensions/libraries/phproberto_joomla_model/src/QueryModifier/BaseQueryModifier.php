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
	 * Query to modify.
	 *
	 * @var  \JDatabaseQuery\
	 */
	protected $query;

	/**
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query  Query to modify
	 */
	public function __construct(\JDatabaseQuery$query)
	{
		$this->query = $query;
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
