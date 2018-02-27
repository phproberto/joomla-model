<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  QueryModifier
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\QueryModifier;

defined('_JEXEC') or die;

/**
 * Modifier to select all rows with values are not in a specified list of values.
 *
 * @since  __DEPLOY_VERSION__
 */
class ValuesNotInColumn extends BaseQueryModifier implements QueryModifierInterface
{
	/**
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query     Query to modify
	 * @param   array            $values    Values to search in the column
	 * @param   string           $column    [description]
	 * @param   callable|null    $callback  [description]
	 */
	public function __construct(\JDatabaseQuery$query, array $values, string $column, callable $callback = null)
	{
		parent::__construct($query);

		$this->values   = $values;
		$this->column   = $column;
		$this->callback = $callback;
	}

	/**
	 * Apply the query filter.
	 *
	 * @return  void
	 */
	public function apply()
	{
		if (!$this->values)
		{
			return;
		}

		if ($this->callback)
		{
			call_user_func_array($this->callback, array($this->query));
		}

		$db = $this->getDbo();

		if (count($this->values) == 1)
		{
			$this->query->where($db->qn($this->column) . ' <> ' . reset($this->values));

			return;
		}

		$this->query->where($db->qn($this->column) . ' NOT IN (' . implode(',', $this->values) . ')');
	}
}
