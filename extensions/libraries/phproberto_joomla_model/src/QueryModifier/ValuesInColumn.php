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
 * Modifier to select all rows with values are in a specified list of values.
 *
 * @since  __DEPLOY_VERSION__
 */
class ValuesInColumn extends BaseQueryModifier implements QueryModifierInterface
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
	 * Constructor.
	 *
	 * @param   \JDatabaseQuery  $query     Query to modify
	 * @param   array            $values    Values to search for.
	 * @param   string           $column    Column where search for values.
	 * @param   callable|null    $callback  Callback to execute if there are values found.
	 */
	public function __construct(\JDatabaseQuery$query, array $values, string $column, callable $callback = null)
	{
		parent::__construct($query, $callback);

		$this->values   = $values;
		$this->column   = $column;
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

		$this->callback();

		$db = $this->getDbo();

		if (count($this->values) == 1)
		{
			$this->query->where($db->qn($this->column) . ' = ' . reset($this->values));

			return;
		}

		$this->query->where($db->qn($this->column) . ' IN (' . implode(',', $this->values) . ')');
	}
}
