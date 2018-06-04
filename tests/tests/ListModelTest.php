<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests;

defined('_JEXEC') || die;

use Joomla\CMS\Factory;
use Phproberto\Joomla\Model\ListModel;
use Phproberto\Joomla\Model\State\FilteredState;
use Phproberto\Joomla\Model\ModelWithStateInterface;
use Phproberto\Joomla\Model\Tests\Stubs\SampleListModel;

/**
 * ListModel tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class ListModelTest extends \TestCaseDatabase
{
	/**
	 * Model instance for tests.
	 *
	 * @var  ListModel
	 */
	protected $model;

	/**
	 * @test
	 *
	 * @return void
	 */
	public function contextReturnsCorrectValue()
	{
		$this->assertSame(1, substr_count($this->model->context(), 'samplelist.'));

		$reflection = new \ReflectionClass($this->model);
		$contextProperty = $reflection->getProperty('context');
		$contextProperty->setAccessible(true);

		$contextProperty->setValue($this->model, 'com_phproberto.test');

		$this->assertSame('com_phproberto.test', $this->model->context());
	}

	/**
	 * Gets the data set to be loaded into the database during setup
	 *
	 * @return  \PHPUnit_Extensions_Database_DataSet_CsvDataSet
	 */
	protected function getDataSet()
	{
		$dataSet = new \PHPUnit_Extensions_Database_DataSet_CsvDataSet(',', "'", '\\');
		$dataSet->addTable('phproberto_items', JPATH_TESTS_PHPROBERTO . '/db/data/phproberto_items.csv');

		return $dataSet;
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function getItemsWorks()
	{
		$this->assertNotSame(0, count($this->model->getItems()));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function getItemsSavesStaticCache()
	{
		$items = $this->model->getItems();

		$this->assertNotSame(0, count($items));

		$reflection = new \ReflectionClass(ListModel::class);
		$staticCacheProperty = $reflection->getProperty('staticCache');
		$staticCacheProperty->setAccessible(true);

		$expected = [
			SampleListModel::class => [
				'0d9cc08bdaf6937d29cdda5769d530ce' => $items
			]
		];

		$this->assertSame($expected, $staticCacheProperty->getValue(ListModel::class));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function getItemsReturnsStaticCache()
	{
		$items = [
			[
				'id' => 222,
				'name' => 'Fake item'
			]
		];

		$staticCache = [
			SampleListModel::class => [
				'0d9cc08bdaf6937d29cdda5769d530ce' => $items
			]
		];

		$reflection = new \ReflectionClass(ListModel::class);
		$staticCacheProperty = $reflection->getProperty('staticCache');
		$staticCacheProperty->setAccessible(true);

		$staticCacheProperty->setValue(ListModel::class, $staticCache);

		$this->assertEquals($items, $this->model->getItems());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function modelImplementsModelWithStateInterface()
	{
		$this->assertInstanceOf(ModelWithStateInterface::class, $this->model);
	}

	/**
	 * Get a mock for a list model.
	 *
	 * @param   array   $methods  Methods that can be mocked
	 *
	 * @return  ListModel
	 */
	private function modelMock(array $methods = [])
	{
		return $this->getMockBuilder(ListModel::class)
			->setMethods($methods)
			->getMock();
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function stateReturnsFilteredStateInstance()
	{
		$model = $this->modelMock(['stateProperties']);

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
		$reflection = new \ReflectionClass($this->model);
		$method = $reflection->getMethod('stateProperties');
		$method->setAccessible(true);

		$this->assertTrue(array_key_exists('list.limit', $method->invoke($this->model)));
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function searchReturnsExpectedValue()
	{
		$items = $this->model->search(['filter.id' => 2]);

		$this->assertSame(1, count($items));
		$this->assertSame('Second item', $items[0]->name);

		$items = $this->model->search(['filter.search' => 'one-item']);

		$this->assertSame(1, count($items));
		$this->assertSame('One item', $items[0]->name);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function setContextSetsContext()
	{
		$context = (new \DateTime)->format('Y-m-d.H:i:s');

		$this->model->setContext($context);

		$this->assertSame($context, $this->model->context());
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->saveFactoryState();

		Factory::$config      = $this->getMockConfig();
		Factory::$session     = $this->getMockSession();
		Factory::$application = $this->getMockCmsApp();

		$this->model = new SampleListModel;
	}

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @return  void
	 */
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();

		$sqlFiles = [
			JPATH_TESTS_PHPROBERTO . '/db/schema/phproberto_items.sql'
		];

		foreach ($sqlFiles as $sqlFile)
		{
			static::$driver->setQuery(
				file_get_contents($sqlFile)
			);

			static::$driver->execute();
		}

		Factory::$database = static::$driver;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return  void
	 */
	protected function tearDown()
	{
		$this->restoreFactoryState();

		$this->model = null;

		$reflection = new \ReflectionClass(ListModel::class);
		$staticCacheProperty = $reflection->getProperty('staticCache');
		$staticCacheProperty->setAccessible(true);

		$staticCacheProperty->setValue(ListModel::class, []);

		parent::tearDown();
	}
}
