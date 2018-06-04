<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Model
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model;

defined('_JEXEC') || die;

use Phproberto\Joomla\Model\State\Filter;
use Phproberto\Joomla\Model\State\FilteredState;
use Phproberto\Joomla\Model\State\FilteredProperty;
use Phproberto\Joomla\Model\Traits\HasQueryFilters;
use Phproberto\Joomla\Model\State\PopulableProperty;
use Phproberto\Joomla\Model\Traits\HasQueryModifiers;
use Joomla\CMS\MVC\Model\ListModel as BaseListModel;

/**
 * Base list model.
 *
 * @since  __DEPLOY_VERSION__
 */
abstract class ListModel extends BaseListModel implements ModelWithStateInterface
{
	use HasQueryModifiers;

	/**
	 * Static cache for items
	 *
	 * @var  array
	 */
	protected static $staticCache = [];

	/**
	 * Gets the model context.
	 *
	 * @return  string  The context
	 */
	public function context()
	{
		return $this->context;
	}

	/**
	 * Method to get an array of data items. Overriden to add static cache support.
	 *
	 * @return  array
	 */
	public function getItems()
	{
		$staticCache = &$this->staticCache();

		$hash = $this->stateHash();

		if (isset($staticCache[$hash]))
		{
			return $staticCache[$hash];
		}

		$staticCache[$hash] = parent::getItems() ?: array();

		return $staticCache[$hash];
	}

	/**
	 * Override because core method doesn't use filters to generate the id
	 *
	 * @param   string  $id  An identifier string to generate the store id.
	 *
	 * @return  string  A store id.
	 */
	protected function getStoreId($id = '')
	{
		return $this->stateHash($id);
	}

	/**
	 * Method to search items based on a state.
	 *
	 * Note: This method clears the model state.
	 *
	 * @param   array  $state  Array with filters + list options
	 *
	 * @return  array
	 */
	public function search($state = array())
	{
		// Clear current state and avoid populateState
		$this->state = new \JObject;
		$this->{'__state_set'} = true;

		foreach ($state as $key => $value)
		{
			$this->setState($key, $value);
		}

		return $this->getItems();
	}

	/**
	 * Sets the context.
	 *
	 * @param   string  $context  The context
	 *
	 * @return  void
	 */
	public function setContext($context)
	{
		$this->context = $context;
	}

	/**
	 * Retrieve the model state.
	 *
	 * @return  FilteredState
	 */
	public function state()
	{
		return new FilteredState($this, $this->stateProperties());
	}

	/**
	 * Gets a unique hash based on a prefix + model state
	 *
	 * @param   string  $prefix  Prefix for the cache
	 *
	 * @return  string
	 */
	protected function stateHash($prefix = null)
	{
		$prefix = $prefix ? $prefix : get_class($this);

		$state = $this->getState()->getProperties();

		ksort($state);

		return md5($this->context . ':' . $prefix . ':' . json_encode($state));
	}

	/**
	 * Get the properties that will be available in this model state.
	 *
	 * @return  array
	 */
	protected function stateProperties()
	{
		return [
			'list.limit' => new FilteredProperty(
				new PopulableProperty('list.limit'),
				new Filter\Integer
			),
			'list.start' => new FilteredProperty(
				new PopulableProperty('list.start'),
				new Filter\Integer
			)
		];
	}

	/**
	 * Gets static cache for this class
	 *
	 * @return  array
	 */
	protected function &staticCache()
	{
		$className = get_class($this);

		if (!isset(static::$staticCache[$className]))
		{
			static::$staticCache[$className] = [];
		}

		return static::$staticCache[$className];
	}
}
