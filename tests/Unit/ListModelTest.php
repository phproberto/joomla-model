<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Unit;

defined('_JEXEC') || die;

use PHPUnit\Framework\TestCase;
use Phproberto\Joomla\Model\ListModel;
use Phproberto\Joomla\Model\State\FilteredState;
use Phproberto\Joomla\Model\ModelWithStateInterface;

/**
 * ListModel tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class ListModelTest extends TestCase
{
	/**
	 * @test
	 *
	 * @return void
	 */
	public function modelImplementsModelWithStateInterface()
	{
		$this->assertInstanceOf(ModelWithStateInterface::class, $this->getMockForAbstractClass(ListModel::class));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function stateReturnsFilteredStateInstance()
	{
		$model = $this->getMockBuilder(ListModel::class)
			->setMethods(array('stateProperties'))
			->getMock();

		$model->expects($this->once())
			->method('stateProperties')
			->willReturn([]);

		$state = $model->state();

		$this->assertInstanceOf(FilteredState::class, $state);

		$reflection = new \ReflectionClass($state);
		$modelProperty = $reflection->getProperty('model');
		$modelProperty->setAccessible(true);

		$this->assertSame($model, $modelProperty->getValue($state));

		$propertiesProperty = $reflection->getProperty('properties');
		$propertiesProperty->setAccessible(true);

		$this->assertEquals([], $propertiesProperty->getValue($state));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function statePropertiesReturnsALimitProperty()
	{
		$model = $this->getMockForAbstractClass(ListModel::class);

		$reflection = new \ReflectionClass($model);
		$method = $reflection->getMethod('stateProperties');
		$method->setAccessible(true);

		$this->assertTrue(array_key_exists('list.limit', $method->invoke($model)));
	}
}
