<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Unit\State\Filter;

defined('_JEXEC') || die;

use PHPUnit\Framework\TestCase;
use Phproberto\Joomla\Model\State\Filter\PositiveInteger;

/**
 * PositiveInteger tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class PositiveIntegerTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			[1, [1]],
			[0, []],
			['1', [1]],
			['123, 0, 15', [123, 15]],
			['0', []],
			['-12,13,-14', [13]],
			[[-12,13,-14], [13]],
			['', []],
			[null, []],
			[[null, ''], []],
			[[null, '', '23', 0], [23]]
		];
	}

	/**
	 * @test
	 *
	 * @dataProvider  filterTestData
	 *
	 * @param   mixed  $value     Value to test
	 * @param   mixed  $expected  Expected result
	 *
	 * @return void
	 */
	public function filterReturnsCorrectValue($value, $expected)
	{
		$filterer = new PositiveInteger;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
