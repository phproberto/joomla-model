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
 * Modifier to select all rows with values are in a specified list of values.
 *
 * @since  __DEPLOY_VERSION__
 */
class DateGreaterInColumn extends BaseQueryModifier implements QueryModifierInterface
{
	/**
	 * Values to search for.
	 *
	 * @var  array
	 */
	protected $values;

	/**
	 * Column where search for values.
	 *
	 * @var  string
	 */
	protected $column;

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
	 * @param   string           $column    Column where search for values.
	 * @param   callable|null    $callback  Callback to execute if there are values found.
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

		foreach ($this->values as $value)
		{
			$this->query->where(sprintf('%s > %s', $db->qn($this->column), $value));
		}
	}
}
