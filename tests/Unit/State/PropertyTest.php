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

use PHPUnit\Framework\TestCase;
use Phproberto\Joomla\Model\State\Property;

/**
 * Property tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class PropertyTest extends TestCase
{
	/**
	 * @test
	 *
	 * @expectedException \RuntimeException
	 *
	 * @return void
	 */
	public function constructorThrowsExceptionForMissingKey()
	{
		$property = new Property('   ');
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function keyCanBeRetrieved()
	{
		$property = new Property('my.key');

		$this->assertSame('my.key', $property->key());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function isPopulableReturnsCorrectValue()
	{
		$property = new Property('my.key');

		$this->assertFalse($property->isPopulable());

		$reflection = new \ReflectionClass($property);
		$isPopulableProperty = $reflection->getProperty('isPopulable');
		$isPopulableProperty->setAccessible(true);

		$isPopulableProperty->setValue($property, true);

		$this->assertTrue($property->isPopulable());
	}
}
