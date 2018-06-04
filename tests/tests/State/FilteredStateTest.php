<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Unit\State;

defined('_JEXEC') || die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Phproberto\Joomla\Model\State\Filter;
use Phproberto\Joomla\Model\State\FilteredState;
use Phproberto\Joomla\Model\State\FilteredProperty;
use Phproberto\Joomla\Model\State\Property;
use Phproberto\Joomla\Model\State\PropertyInterface;

/**
 * FilteredState tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class FilteredStateTest extends \TestCaseDatabase
{
	/**
	 * @test
	 *
	 * @return void
	 */
	public function getReturnsFilteredValue()
	{
		$model = $this->getMockBuilder(BaseDatabaseModel::class)
			->setMethods(array('getState'))
			->getMock();

		$model->expects($this->once())
			->method('getState')
			->with($this->equalTo('filter.sample'), $this->equalTo('defaultValue'))
			->willReturn('23, 45');

		$properties = [
			new FilteredProperty(
				new Property('filter.sample'),
				new Filter\Integer
			)
		];

		$state = new FilteredState($model, $properties);

		$this->assertSame([23, 45], $state->get('filter.sample', 'defaultValue'));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function getReturnsStringQuotedValueIfExceptionHappens()
	{
		$model = $this->getMockBuilder(BaseDatabaseModel::class)
			->setMethods(array('getState'))
			->getMock();

		$model->expects($this->once())
			->method('getState')
			->with($this->equalTo('filter.sample'), $this->equalTo('defaultValue'))
			->willReturn('23, 45');

		$state = new FilteredState($model);

		$this->assertSame(['\'23\'', '\'45\''], $state->get('filter.sample', 'defaultValue'));
	}
}
