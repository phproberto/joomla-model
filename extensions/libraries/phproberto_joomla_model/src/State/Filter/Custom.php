<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  State\Filter
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\State\Filter;

defined('_JEXEC') or die;

/**
 * Integer values filterer.
 *
 * @since  __DEPLOY_VERSION__
 */
class Custom extends BaseFilter
{
	/**
	 * Filter value function.
	 *
	 * @var  callable
	 */
	private $filterValueFunction;

	/**
	 * Prepare value function.
	 *
	 * @var  callable
	 */
	private $prepareValueFunction;

	/**
	 * Constructorl
	 *
	 * @param   callable       $filterValueFunction   Filtering function
	 * @param   callable|null  $prepareValueFunction  Prepare function
	 * @param   array          $options               Additional options
	 */
	public function __construct(callable $filterValueFunction, callable $prepareValueFunction = null, array $options = [])
	{
		parent::__construct($options);

		$this->filterValueFunction = $filterValueFunction;
		$this->prepareValueFunction = $prepareValueFunction;
	}

	/**
	 * Determine if a value will be used or not.
	 *
	 * @param   mixed  $value  Value to filter
	 *
	 * @return  boolean
	 */
	protected function filterValue($value)
	{
		return call_user_func($this->filterValueFunction, $value);
	}

	/**
	 * Prepare value.
	 *
	 * @param   mixed  $value  Value to prepare
	 *
	 * @return  mixed
	 */
	public function prepareValue($value)
	{
		$value = parent::prepareValue($value);

		if (!$this->prepareValueFunction)
		{
			return $value;
		}

		return call_user_func($this->prepareValueFunction, $value);
	}
}
