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
	 * Retrieve the model state.
	 *
	 * @return  FilteredState
	 */
	public function state()
	{
		return new FilteredState($this, $this->stateProperties());
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
			)
		];
	}
}
