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
use Phproberto\Joomla\Model\State\Filter\StringFilter;

/**
 * StringFilter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class StringFilterTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			['test', ['test']],
			[' test2', ['test2']],
			[2016, ['2016']],
			['2016', ['2016']],
			[[false, true], []],
			['', []],
			[[' '], []],
			[['', null], []]
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
		$filterer = new StringFilter;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
