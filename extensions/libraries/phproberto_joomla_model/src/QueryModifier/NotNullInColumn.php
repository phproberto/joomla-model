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

/**
 * Modifier .
 *
 * @since  __DEPLOY_VERSION__
 */
class NotNullInColumn extends BaseQueryModifier implements QueryModifierInterface
{
	/**
	 * Column where search for values.
	 *
	 * @var  string
	 */
	protected $column;

	/**
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query     Query to modify
	 * @param   string           $column    Column where search for NULL value.
	 * @param   callable|null    $callback  Callback to execute if there are values found.
	 */
	public function __construct(\JDatabaseQuery$query, string $column, callable $callback = null)
	{
		parent::__construct($query, $callback);

		$this->column = $column;
	}

	/**
	 * Apply the query filter.
	 *
	 * @return  void
	 */
	public function apply()
	{
		$this->callback();

		$db = $this->getDbo();

		$this->query->where($db->qn($this->column) . ' IS NOT NULL');
	}
}
