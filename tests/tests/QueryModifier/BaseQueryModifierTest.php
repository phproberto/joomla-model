<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Model\Tests\Unit\QueryModifier;

defined('_JEXEC') || die;

use Joomla\CMS\Factory;
use Phproberto\Joomla\Model\QueryModifier\BaseQueryModifier;

/**
 * BaseQueryModifier tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class BaseQueryModifierTest extends \TestCase
{
	/**
	 * @test
	 *
	 * @return void
	 */
	public function classIsAbstract()
	{
		$reflection = new \ReflectionClass(BaseQueryModifier::class);

		$this->assertTrue($reflection->isAbstract());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function constructorSetsQuery()
	{
		$query = Factory::getDbo()->getQuery(true);

		$modifier = $this->getMockForAbstractClass(BaseQueryModifier::class, [$query]);

		$reflection = new \ReflectionClass($modifier);
		$queryProperty = $reflection->getProperty('query');
		$queryProperty->setAccessible(true);

		$this->assertSame($query, $queryProperty->getValue($modifier));
	}
}
