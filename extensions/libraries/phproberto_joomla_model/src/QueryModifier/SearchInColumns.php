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
 * Modifier to select all rows with values like in a specified list of values.
 *
 * @since  __DEPLOY_VERSION__
 */
class SearchInColumns extends BaseQueryModifier implements QueryModifierInterface
{
	/**
	 * Values to search for.
	 *
	 * @var  array
	 */
	protected $values;

	/**
	 * Columns where search for values.
	 *
	 * @var  array
	 */
	protected $columns;

	/**
	 * Callback to execute if there are values found.
	 *
	 * @var  callable|null
	 */
	protected $callback;

	/**
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query     Query to modify
	 * @param   array            $values    Values to search for.
	 * @param   string           $columns   Columns where search for values.
	 * @param   callable|null    $callback  Callback to execute if there are values found.
	 */
	public function __construct(\JDatabaseQuery$query, array $values, array $columns, callable $callback = null)
	{
		parent::__construct($query);

		$this->values   = $values;
		$this->columns  = $columns;
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

		foreach ($this->values as $value)
		{
			$like = $db->quote('%' . trim($value, "'") . '%');
			$whereParts = array();

			foreach ($this->columns as $column)
			{
				$whereParts[] = sprintf('%s', $db->qn($column) . ' LIKE ' . $like);
			}

			$where = sprintf('(%s)', implode(' OR ', $whereParts));

			$this->query->where($where);
		}
	}
}