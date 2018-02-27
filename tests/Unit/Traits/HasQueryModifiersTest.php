<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright  Copyright (C) 2017 Roberto Segura López, Inc. All rights reserved.
 * @license    See COPYING.txt
 */

namespace Phproberto\Joomla\Model\Tests\Unit\Traits;

defined('_JEXEC') || die;

use Phproberto\Joomla\Model\Traits\HasQueryModifiers;
use Phproberto\Joomla\Model\QueryModifier\QueryModifierInterface;

/**
 * HasQueryModifiers tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class HasQueryModifiersTest extends \TestCase
{
	private $instance;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->instance = $this->getMockForTrait(HasQueryModifiers::class);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function applyQueryModifierWorks()
	{
		$this->instance->applyQueryModifier($this->mandatoryQueryModifier());
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function applyQueryModifiersWorks()
	{
		$this->instance->applyQueryModifiers(
			[
				$this->mandatoryQueryModifier(),
				$this->mandatoryQueryModifier()
			]
		);
	}

	/**
	 * Generate a mock for a mandatory query modifier.
	 *
	 * @return  QueryModifierInterface
	 */
	private function mandatoryQueryModifier()
	{
		$modifier = $this->getMockBuilder(QueryModifierInterface::class)
			->setMethods(array('apply'))
			->getMock();

		$modifier->expects($this->once())
			->method('apply');

		return $modifier;
	}
}
