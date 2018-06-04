<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Stubs;

defined('_JEXEC') || die;

use Phproberto\Joomla\Model\ListModel;
use Phproberto\Joomla\Model\State\Filter;
use Phproberto\Joomla\Model\QueryModifier;
use Phproberto\Joomla\Model\State\Property;
use Phproberto\Joomla\Model\State\FilteredProperty;
use Phproberto\Joomla\Model\State\PopulableProperty;

/**
 * Sample list model for tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class SampleListModel extends ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  [description]
	 *
	 * @see  JController
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = [
			];
		}

		parent::__construct($config);
	}

	/**
	 * Method to cache the last query constructed.
	 *
	 * This method ensures that the query is constructed only once for a given state of the model.
	 *
	 * @param   bool  $newQuery  use new query or not to improve performance
	 *
	 * @return JDatabaseQuery A JDatabaseQuery object
	 */
	public function getListQuery($newQuery = true)
	{
		$db = $this->getDbo();
		$query = $db->getQuery($newQuery);

		$query
			->select('pi.*')
			->from($db->qn('phproberto_items', 'pi'));

		$this->applyQueryModifiers(
			[
				new QueryModifier\ValuesInColumn($query, $this->state()->get('filter.id'), 'pi.id'),
				new QueryModifier\ValuesNotInColumn($query, $this->state()->get('filter.not_id'), 'pi.id'),
				new QueryModifier\SearchInColumns(
					$query,
					$this->state()->get('filter.search'),
					[
						'pi.name', 'pi.alias'
					]
				)
			]
		);

		// Get the ordering modifiers
		$orderCol = $this->state->get('list.ordering', 'pi.name');
		$orderDirn = $this->state->get('list.direction', 'ASC');
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}

	/**
	 * Model properties.
	 *
	 * @return  array
	 */
	protected function stateProperties()
	{
		return array_merge(
			parent::stateProperties(),
			[
				'filter.id' => new FilteredProperty(
					new PopulableProperty('filter.id'),
					new Filter\PositiveInteger
				),
				'filter.notid' => new FilteredProperty(
					new PopulableProperty('filter.not_id'),
					new Filter\PositiveInteger
				),
				'filter.search' => new FilteredProperty(
					new Property('filter.search'),
					new Filter\StringQuoted
				)
			]
		);
	}
}
