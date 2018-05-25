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
 * Modifier to check that a column is not empty.
 *
 * @since  __DEPLOY_VERSION__
 */
class NotEmptyColumn extends BaseQueryModifier implements QueryModifierInterface
{
	/**
	 * Column where search for values.
	 *
	 * @var  string
	 */
	protected $column;

	/**
	 * Vales that will be considered empty.
	 *
	 * @var  array
	 */
	protected $emptyValues = [
		'', '0', '0000-00-00', '0000-00-00 00:00:00'
	];

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

		$values = array_map([$db, 'quote'], $this->emptyValues);

		$this->query->where($db->qn($this->column) . ' IS NOT NULL')
			->where($db->qn($this->column) . ' NOT IN (' . implode(', ', $values) . ')');
	}
}
